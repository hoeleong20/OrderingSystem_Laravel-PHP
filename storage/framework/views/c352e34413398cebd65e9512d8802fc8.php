<?php if (isset($component)) { $__componentOriginalcdcf367506f8add23f892fb5023cf138 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdcf367506f8add23f892fb5023cf138 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.orderLayout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('orderLayout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-10">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-normal mb-0">Your Order</h3>
      </div>

      <div class="orders">
        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- <?php echo e($cartItem); ?> -->
        <div class="card rounded-3 mb-4">
          <div class="card-body p-4">
            <div class="row d-flex justify-content-between align-items-center">
              <div class="col-md-2 col-lg-2 col-xl-2">
                <img
                  src="images/f1.png"
                  class="img-fluid rounded-3" alt="Cotton T-shirt">
              </div>
              <div class="col-md-3 col-lg-3 col-xl-3">
                <p class="lead fw-normal mb-2"><?php echo e($cartItem->foodName); ?></p>
              </div>
              <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                <button class="btn btn-link px-2" onclick="updateQuantity(<?php echo e($cartItem->id); ?>, 'decrease')">
                  <i class="fas fa-minus"></i>
                </button>

                <input id="quantity-<?php echo e($cartItem->id); ?>" min="0" name="quantity" value="<?php echo e($cartItem->quantity); ?>" type="number" class="form-control form-control-sm" />

                <button class="btn btn-link px-2" onclick="updateQuantity(<?php echo e($cartItem->id); ?>, 'increase')">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                <h5 class="mb-0">RM <?php echo e($cartItem->foodPrice); ?></h5>
              </div>
              <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                <a href="#!" class="text-danger" onclick="deleteRecord(<?php echo e($cartItem->id); ?>)"><i class="fas fa-trash fa-lg"></i></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>






      <div class="card fixed-bottom flex-row col-7 mb-3" style="margin:auto">
        <div class="card-body d-flex flex-row ">
          <a type="button" class="btn btn-outline-warning btn-lg col-6" id="goToMenuBtn" href="<?php echo e(route('menus.index')); ?>">Add More Items</a>
          <a type="button" class="btn btn-warning btn-block btn-lg ms-3 col-6" id="placeOrderBtn" href="<?php echo e(route('order.checkOut')); ?>">Place Order</a>

        </div>
      </div>

      <div class="card">

      </div>

    </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdcf367506f8add23f892fb5023cf138)): ?>
<?php $attributes = $__attributesOriginalcdcf367506f8add23f892fb5023cf138; ?>
<?php unset($__attributesOriginalcdcf367506f8add23f892fb5023cf138); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdcf367506f8add23f892fb5023cf138)): ?>
<?php $component = $__componentOriginalcdcf367506f8add23f892fb5023cf138; ?>
<?php unset($__componentOriginalcdcf367506f8add23f892fb5023cf138); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\RestaurantOrderingSystem-main\resources\views/order/index.blade.php ENDPATH**/ ?>