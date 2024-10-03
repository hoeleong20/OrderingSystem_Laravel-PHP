<?php

namespace App\Http\Controllers;

// Author : Chong Soon He

use GuzzleHttp\Client;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Factories\DiscountFactory;
use Exception;

use DOMDocument;
use XSLTProcessor;
use DOMXPath;

class DiscountController extends Controller
{
    private $xmlFilePath = 'app/discount.xml';

    public function index()
    {
        $discounts = Discount::withCount('orders')->get();

        // Generate XML
        $xmlDom = new DOMDocument();
        $root = $xmlDom->createElement('discounts');
        $xmlDom->formatOutput = true;

        if ($discounts->isEmpty()) {
            // Add a comment or an empty node indicating no discounts available
            $comment = $xmlDom->createComment('No discount available');
            $root->appendChild($comment);
        } else {
            foreach ($discounts as $discount) {
                $this->generateXml($discount, $root, $xmlDom);
            }
        }
        
        $xmlFilePath = storage_path($this->xmlFilePath);
        $this->xmlFilePath = $xmlFilePath;
        
        $xmlDom->appendChild($root);
        $xmlDom->save($this->xmlFilePath);

        $xslFilePath = resource_path('views/xslt/discountTable.xsl');
        $html = $this->transformXsl($xslFilePath, $xmlDom);

        return view('discount.index', ['html' => $html]);
    }

    public function view($id) {
        $xmlFilePath = storage_path($this->xmlFilePath);
        $xmlDom = new DOMDocument;
        $xmlDom->load($xmlFilePath);

        // Create a new DOMXPath object
        $xpath = new DOMXPath($xmlDom);
        $discountNode = $xpath->query("//discount[id='$id']")->item(0);

        // Handle the case where the discount is not found
        if (!$discountNode) {
            Log::error('Discount not found', ['discount_id' => $id]);
            return response()->json(['error' => 'Discount not found'], 404);
        }

        $discountXmlDom = new DOMDocument;
        $discountXmlDom->appendChild($discountXmlDom->importNode($discountNode, true));

        $xslFilePath = resource_path('views/xslt/discountView.xsl');
        $html = $this->transformXsl($xslFilePath, $discountXmlDom);

        Log::info('Discount viewed successfully.', ['discount_id' => $id]);
        return response($html);
    }

    public function create()
    {
        $xmlDom = new DOMDocument();
        $xslFilePath = resource_path('views/xslt/discountAdd.xsl');
        $params = [
            'formUrl' => route('discount.store'),
        ];
        $html = $this->transformXsl($xslFilePath, $xmlDom, $params);

        return response($html);
    }

    public function store(Request $request)
    {        
        try {
            $this->validateForm($request);
        } catch (ValidationException $e) {
            Log::error('Discount creation failed', ['errors' => $e->validator->errors()]);
            return response()->json(['errors' => $e->validator->errors()], 422);
        }

        // merge criteria and condition with comma
        $criteria = implode(', ',$request->input('criteriaNames', []));
        $condition = implode(', ',$request->input('conditions', []));

        $discount = new Discount;
        $discount->name = $request->input('name');
        $discount->description = $request->input('description');
        $discount->promo_code = $request->input('promo_code');
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->total_usage = $request->input('total_usage');
        $discount->usage_per_user = $request->input('usage_per_user');
        $discount->criteria = $criteria;
        $discount->condition = $condition;
        $discount->discount_type = $request->input('discount_type');
        $discount->discount_value = $request->input('discount_value');

        $discount->save();

        Log::info('Discount created successfully.', ['discount' => $discount]);
        return response()->json(['message' => 'Discount created successfully.', 'discount' => $discount]);
    }

    public function edit($id)
    {
        $xmlFilePath = storage_path($this->xmlFilePath);
        $xmlDom = new DOMDocument;
        $xmlDom->load($xmlFilePath);

        $xpath = new DOMXPath($xmlDom);
        $discountNode = $xpath->query("//discount[id='$id']")->item(0);

        if (!$discountNode) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $discountXmlDom = new DOMDocument;
        $discountXmlDom->appendChild($discountXmlDom->importNode($discountNode, true));
        $xslFilePath = resource_path('views/xslt/discountEdit.xsl');

        $params = [
            'formUrl' => route('discount.update', ['id' => $id]),
        ];
        $html = $this->transformXsl($xslFilePath, $discountXmlDom, $params);

        return response($html);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validateForm($request);
        } catch (ValidationException $e) {
            Log::error('Discount update failed', ['errors' => $e->validator->errors()]);
            return response()->json(['errors' => $e->validator->errors()], 422);
        }

        // merge criteria and condition with comma
        $criteria = implode(', ',$request->input('criteriaNames', []));
        $condition = implode(', ',$request->input('conditions', []));

        // Find the discount by ID
        $discount = Discount::findOrFail($id);
        $discount->name = $request->input('name');
        $discount->description = $request->input('description');
        $discount->promo_code = $request->input('promo_code');
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->total_usage = $request->input('total_usage');
        $discount->usage_per_user = $request->input('usage_per_user');
        $discount->criteria = $criteria;
        $discount->condition = $condition;
        $discount->discount_type = $request->input('discount_type');
        $discount->discount_value = $request->input('discount_value');

        // Save the updated discount
        $discount->save();

        Log::info('Discount updated successfully.', ['discount' => $discount]);
        // Return a success response
        return response()->json(['message' => 'Discount updated successfully.', 'discount' => $discount]);
    }

    public function check(Request $request)
    {
        $promoCode = $request->input('promoCode');
        // $userId = Auth::id();
        $userId = '3';
        $totalAmount = $request->input('totalAmount');

        $query = [
            'total_amount' => $totalAmount,
            'user_id' => $userId,
        ];
        
        if ($promoCode !== null && $promoCode !== '') {
            $query['promo_code'] = $promoCode;
        }

        $client = new Client();
        try {
            $response = $client->get('http://localhost:8080/checkDiscount', [
                'query' => $query
            ]);
        } catch (Exception $e) {
            Log::error('Request failed to check discount : ' . $e->getMessage());

            if ($promoCode === null || $promoCode === '') {
                return response()->json(['promo_code' => '']);
            }

            return response()->json(['error' => 'Failed to fetch discount data.', 'message' => $e->getMessage()], 500);
        }

        $responseBody = (string) $response->getBody();
        if ($response->getStatusCode() !== 200) {
            Log::info('Failed to check discount, the web service returned an error.');
            return response()->json(['error' => 'Failed to check discount'], 500);
        }

        if ($promoCode === null || $promoCode === '') {
            if (str_starts_with($responseBody, "error: ")) {
                return response()->json(['promo_code' => '']);
            }
            return response()->json(['promo_code' => $responseBody]);
        }

        if (str_starts_with($responseBody, "error: ")) {
            Log::info('Discount check failed.', ['promo_code' => $promoCode, 'error' => $responseBody]);
            return response()->json(['error' => str_replace('error: ', '', $responseBody)], 422);
        }

        Log::info('Discount checked successfully.', ['promo_code' => $promoCode]);
        return response()->json(['promo_code' => $responseBody]);
    }

    public function calculate(Request $request) {
        $promoCode = trim($request->input('promoCode'));
        $totalAmount = $request->input('totalAmount');

        $discount = Discount::where('promo_code', $promoCode)
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$discount) {
            Log::info('Invalid promo code.', ['promo_code' => $promoCode]);
            return response()->json(['error' => 'Invalid promo code'], 422);
        }

        $discountFactory = null;
        if ($discount->discount_type === 'percentage') {
            $discountFactory = DiscountFactory::createDiscount('percentage', $discount->discount_value);
        } else {
            $discountFactory = DiscountFactory::createDiscount('fixed', $discount->discount_value);
        }

        $discountAmount = $discountFactory->applyDiscount($totalAmount);

        Log::info('Discount calculated successfully.', ['discount_amount' => $discountAmount]);
        return response()->json(['discount_amount' => $discountAmount, 'discount_type' => $discount->discount_type, 'discount_value' => $discount->discount_value]);
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->status = 'inactive';
        $discount->save();

        Log::info('Discount deleted successfully.', ['discount' => $discount]);
        return response()->json(['success' => true, 'message' => 'Discount deleted successfully']);
    }

    public function activate(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->status = 'active';
        $discount->save();

        Log::info('Discount activated successfully.', ['discount' => $discount]);
        return response()->json(['success' => true, 'message' => 'Discount activated successfully']);
    }

    private function generateXml($discount, $root, $xmlDom) {
        $discountNode = $xmlDom->createElement('discount');
        
        $idNode = $xmlDom->createElement('id', htmlspecialchars($discount->id));
        $nameNode = $xmlDom->createElement('name', htmlspecialchars($discount->name));
        $descriptionNode = $xmlDom->createElement('description', htmlspecialchars($discount->description));
        $promoCodeNode = $xmlDom->createElement('promo_code', htmlspecialchars($discount->promo_code));
        $startDateNode = $xmlDom->createElement('start_date', htmlspecialchars($discount->start_date->format('Y-m-d')));
        $endDateNode = $xmlDom->createElement('end_date', htmlspecialchars($discount->end_date->format('Y-m-d')));
        $totalUsageNode = $xmlDom->createElement('total_usage', htmlspecialchars($discount->total_usage));
        $usagePerUserNode = $xmlDom->createElement('usage_per_user', htmlspecialchars($discount->usage_per_user));
        $usedCountNode = $xmlDom->createElement('used_count', htmlspecialchars($discount->orders_count));
        $discountTypeNode = $xmlDom->createElement('discount_type', htmlspecialchars($discount->discount_type));
        $discountValueNode = $xmlDom->createElement('discount_value', htmlspecialchars($discount->discount_value));
        $statusNode = $xmlDom->createElement('status', htmlspecialchars($discount->status));

        $discountNode->appendChild($idNode);
        $discountNode->appendChild($nameNode);
        $discountNode->appendChild($descriptionNode);
        $discountNode->appendChild($promoCodeNode);
        $discountNode->appendChild($startDateNode);
        $discountNode->appendChild($endDateNode);
        $discountNode->appendChild($totalUsageNode);
        $discountNode->appendChild($usagePerUserNode);
        $discountNode->appendChild($usedCountNode);

        if (trim($discount->criteria) !== '') {
            $criterias = explode(', ', trim($discount->criteria));
            $conditions = explode(', ', trim($discount->condition));

            $criteriasNode = $xmlDom->createElement('criterias');
            foreach ($criterias as $index => $criteria) {
                $criteriaNode = $xmlDom->createElement('criteria');
                $criteriaNameNode = $xmlDom->createElement('name', htmlspecialchars($criterias[$index]));
                $conditionNode = $xmlDom->createElement('condition', htmlspecialchars($conditions[$index]));

                $criteriaNode->appendChild($criteriaNameNode);
                $criteriaNode->appendChild($conditionNode);

                $criteriasNode->appendChild($criteriaNode);
            }
            $discountNode->appendChild($criteriasNode);
        }
        $discountNode->appendChild($discountTypeNode);
        $discountNode->appendChild($discountValueNode);
        $discountNode->appendChild($statusNode);

        $root->appendChild($discountNode);
    }

    private function transformXsl($xslFilePath, $xmlDom, $params = []) {
        if (!file_exists($xslFilePath)) {
            Log::error('XSL file not found', ['xsl_file' => $xslFilePath]);
            return response()->json(['error' => 'XSL file not found'], 404);
        }

        $xslDom = new DOMDocument();
        $xslDom->load($xslFilePath);

        $xsltProcessor = new XSLTProcessor();
        $xsltProcessor->importStylesheet($xslDom);

        foreach ($params as $key => $value) {
            $xsltProcessor->setParameter('', $key, $value);
        }

        $html = $xsltProcessor->transformToXML($xmlDom);

        Log::info('XSL transformation successful.');
        return $html;
    }

    private function validateForm(Request $request) {
        // Custom validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'promo_code' => 'required|string|max:50',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
            'total_usage' => 'required|integer',
            'usage_per_user' => 'required|integer',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Custom validation for promo_code uniqueness in active discounts
        $validator->after(function ($validator) use ($request) {
            $activeDiscounts = Discount::where('status', 'active')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                })
                ->where('promo_code', $request->promo_code)
                ->where('id', '<>', $request->id)
                ->exists();

            if ($activeDiscounts) {
                $validator->errors()->add('promo_code', 'The promo code cannot be the same with other active discounts in the same date range.');
            }

            // Validate criteria and conditions
            $criteria = $request->input('criteriaNames', []);
            $conditions = $request->input('conditions', []);

            foreach ($criteria as $i => $criterion) {
                if ($criterion === 'newUser') {
                    $day = $request->input("newUserDay.$i");
                    $timeUnit = $request->input("newUserTimeUnit.$i");
            
                    // Check if both fields are present
                    if (is_null($day) || is_null($timeUnit)) {
                        $validator->errors()->add("conditions.{$i}", 'Both day and time unit are required.');
                        continue;
                    }
            
                    // Validate the day input
                    if (!is_numeric($day) || (int)$day < 1) {
                        $validator->errors()->add("conditions.{$i}", 'The number of days must be a positive integer.');
                    }
            
                    // Validate the time unit input
                    if (!in_array($timeUnit, ['days', 'months', 'years'])) {
                        $validator->errors()->add("conditions.{$i}", 'The time unit must be either "days", "months", or "years".');
                    }
            
                    // Combine the day and time unit for further processing if necessary
                    $combinedCondition = "{$day} {$timeUnit}";
                    $hiddenInput = $request->input("conditions.$i", '');
                    $hiddenInput = $combinedCondition; // Set the combined condition
                } elseif ($criterion === 'min_purchase') {
                    Log::info('min_purchase');
                    Log::info($conditions[$i]);
                    // check if condition can be converted to double, and more equal 0
                    if (!is_numeric($conditions[$i]) || (double)$conditions[$i] < 0) {
                        $validator->errors()->add("conditions.{$i}", 'The minimum purchase condition must be a positive number.');
                    }
                }
            }

            // Validate discount value for percentage type
            if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
                $validator->errors()->add('discount_value', 'The discount value must be less than or equal to 100 for percentage discounts.');
            }
        });

        // If validation fails, throw validation exception
        if ($validator->fails()) {
            Log::error($validator->errors());
            throw new ValidationException($validator);
        }

        Log::info('Discount form validated successfully.');
    }
}