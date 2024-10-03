<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    <xsl:param name="formUrl"/>

    <xsl:template match="/">
        <form action="{$formUrl}" method="POST" onsubmit="mergeFormInput(this)">
            <xsl:call-template name="csrf"/>
            <div class="form-group">
                <!-- Discount Name -->
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="" required="true" /><br/>

                <!-- Discount Description -->
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" 
                       value="" required="true" /><br/>

                <!-- Promo Code -->
                <label for="promo_code">Promo Code</label>
                <input type="text" name="promo_code" id="promo_code" class="form-control" 
                       value="" required="true" /><br/>

                <!-- Start Date -->
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" 
                       value="" required="true" /><br/>

                <!-- End Date -->
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" 
                       value="" required="true" /><br/>

                <!-- Total Usage -->
                <label for="total_usage">Total Usage Allowed (-1 for unlimited)</label>
                <input type="number" name="total_usage" id="total_usage" class="form-control" 
                       value="" required="true" min="-1" /><br/>

                <!-- Usage Per User -->
                <label for="usage_per_user">Usage Per User</label>
                <input type="number" name="usage_per_user" id="usage_per_user" class="form-control" 
                       value="" required="true" min="-1" /><br/>

                <!-- Criteria List -->
                <div class="form-group">
                    <label>Criteria</label><br/>
                    <div id="criteriaContainer">                        
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="addCriteriaButton">Add Criteria</button>
                </div><br/>

                <!-- Discount Type -->
                <label for="discount_type">Discount Type</label>
                <select name="discount_type" id="discount_type" class="form-control" onchange="updateDiscountValueInput()">
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                </select>

                <!-- Discount Value -->
                <div class="input-group" style="margin-top:5px;">
                    <span class="input-group-text" id="discount_prefix" style="display:none;">RM
                    </span>
                    <input type="text" name="discount_value" id="discount_value" class="form-control" value="" required="true" min="0"/>
                    <span class="input-group-text" id="discount_suffix">%</span>
                </div>
            </div>

            <!-- Save Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal" style="margin-left: 10px;">Close</button>
            </div>
        </form>
    </xsl:template>

    <!-- CSRF Token Template -->
    <xsl:template name="csrf">
        <input type="hidden" name="_token" value="{token}"/>
    </xsl:template>
</xsl:stylesheet>
