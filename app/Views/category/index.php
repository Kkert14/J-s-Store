<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Categories</h1>
            <div class="dash-subtitle">Manage product categories</div>
          </div>
        </div>
        <!-- <div class="col-sm-6 d-flex align-items-center justify-content-sm-end">
          <div class="dash-date">
            <i class="far fa-calendar-alt"></i>
            <?= date('F d, Y') ?>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-tags"></i>
                </span>
                Category List
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddCategoryModal">
                  <i class="fa fa-plus-circle mr-1"></i> Add New
                </button>
              </div>
            </div>

            <div class="card-body">
              <table id="categoryTable" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="AddCategoryModal" tabindex="-1">
        <div class="modal-dialog">
          <form id="addCategoryForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add Category</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="category-select">Product Category</label>

                  <select id="category-select" name="name" class="form-control" required>

                    <option value="" disabled selected>Choose category...</option>

                    <!-- Food & Drinks -->
                    <option value="Beverages">Beverages</option>
                    <option value="Coffee">Coffee</option>
                    <option value="Milk Tea">Milk Tea</option>
                    <option value="Soft Drinks">Soft Drinks</option>
                    <option value="Juices">Juices</option>
                    <option value="Energy Drinks">Energy Drinks</option>
                    <option value="Water">Water</option>

                    <option value="Food snacks">Snacks</option>
                    <option value="Chips">Chips</option>
                    <option value="Biscuits">Biscuits</option>
                    <option value="Candies">Candies</option>
                    <option value="Chocolate">Chocolate</option>

                    <option value="Appetizers">Appetizers</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Fast food">Fast Food</option>
                    <option value="Meals">Meals</option>
                    <option value="Rice Meals">Rice Meals</option>
                    <option value="Noodles">Noodles</option>
                    <option value="Pasta">Pasta</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Burgers">Burgers</option>
                    <option value="Sandwiches">Sandwiches</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Seafood">Seafood</option>
                    <option value="Chicken">Chicken</option>
                    <option value="Pork">Pork</option>
                    <option value="Beef">Beef</option>
                    <option value="Vegetarian">Vegetarian</option>

                    <!-- Bakery -->
                    <option value="Bread">Bread</option>
                    <option value="Pastries">Pastries</option>
                    <option value="Cakes">Cakes</option>
                    <option value="Donuts">Donuts</option>

                    <!-- Frozen -->
                    <option value="Frozen Foods">Frozen Foods</option>
                    <option value="Ice Cream">Ice Cream</option>

                    <!-- Grocery -->
                    <option value="Canned Goods">Canned Goods</option>
                    <option value="Instant Foods">Instant Foods</option>
                    <option value="Condiments">Condiments</option>
                    <option value="Cooking Oil">Cooking Oil</option>
                    <option value="Rice">Rice</option>
                    <option value="Eggs">Eggs</option>
                    <option value="Dairy">Dairy</option>

                    <!-- Fruits & Vegetables -->
                    <option value="Fruits">Fruits</option>
                    <option value="Vegetables">Vegetables</option>

                    <!-- Personal Care -->
                    <option value="Personal Care">Personal Care</option>
                    <option value="Soap">Soap</option>
                    <option value="Shampoo">Shampoo</option>
                    <option value="Toothpaste">Toothpaste</option>
                    <option value="Skincare">Skincare</option>
                    <option value="Cosmetics">Cosmetics</option>

                    <!-- Household -->
                    <option value="Household Items">Household Items</option>
                    <option value="Cleaning Supplies">Cleaning Supplies</option>
                    <option value="Laundry">Laundry</option>
                    <option value="Kitchenware">Kitchenware</option>

                    <!-- School & Office -->
                    <option value="School Supplies">School Supplies</option>
                    <option value="Office Supplies">Office Supplies</option>
                    <option value="Books">Books</option>
                    <option value="Pens">Pens</option>
                    <option value="Paper">Paper</option>

                    <!-- Electronics -->
                    <option value="Electronics">Electronics</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Chargers">Chargers</option>
                    <option value="Headphones">Headphones</option>

                    <!-- Clothing -->
                    <option value="Clothing">Clothing</option>
                    <option value="Men Clothing">Men Clothing</option>
                    <option value="Women Clothing">Women Clothing</option>
                    <option value="Kids Clothing">Kids Clothing</option>
                    <option value="Footwear">Footwear</option>

                    <!-- Health -->
                    <option value="Medicine">Medicine</option>
                    <option value="Vitamins">Vitamins</option>
                    <option value="Medical Supplies">Medical Supplies</option>

                    <!-- Pet -->
                    <option value="Pet Food">Pet Food</option>
                    <option value="Pet Supplies">Pet Supplies</option>

                    <!-- Others -->
                    <option value="Miscellaneous">Miscellaneous</option>

                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal fade" id="EditCategoryModal" tabindex="-1">
        <div class="modal-dialog">
          <form id="editCategoryForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-edit"></i> Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>


              <div class="modal-body">
                <!-- Hidden input for record ID -->
                <input type="hidden" name="id" id="edit_category_id">

                <div class="form-group">
                  <label for="edit_category_name">Product Category</label>
                  <select id="edit_category_name" name="name" class="form-control" required>

                    <option value="" disabled selected>Choose category...</option>

                    <!-- Food & Drinks -->
                    <option value="Beverages">Beverages</option>
                    <option value="Coffee">Coffee</option>
                    <option value="Milk Tea">Milk Tea</option>
                    <option value="Soft Drinks">Soft Drinks</option>
                    <option value="Juices">Juices</option>
                    <option value="Energy Drinks">Energy Drinks</option>
                    <option value="Water">Water</option>

                    <option value="Food snacks">Snacks</option>
                    <option value="Chips">Chips</option>
                    <option value="Biscuits">Biscuits</option>
                    <option value="Candies">Candies</option>
                    <option value="Chocolate">Chocolate</option>

                    <option value="Appetizers">Appetizers</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Fast food">Fast Food</option>
                    <option value="Meals">Meals</option>
                    <option value="Rice Meals">Rice Meals</option>
                    <option value="Noodles">Noodles</option>
                    <option value="Pasta">Pasta</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Burgers">Burgers</option>
                    <option value="Sandwiches">Sandwiches</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Seafood">Seafood</option>
                    <option value="Chicken">Chicken</option>
                    <option value="Pork">Pork</option>
                    <option value="Beef">Beef</option>
                    <option value="Vegetarian">Vegetarian</option>

                    <!-- Bakery -->
                    <option value="Bread">Bread</option>
                    <option value="Pastries">Pastries</option>
                    <option value="Cakes">Cakes</option>
                    <option value="Donuts">Donuts</option>

                    <!-- Frozen -->
                    <option value="Frozen Foods">Frozen Foods</option>
                    <option value="Ice Cream">Ice Cream</option>

                    <!-- Grocery -->
                    <option value="Canned Goods">Canned Goods</option>
                    <option value="Instant Foods">Instant Foods</option>
                    <option value="Condiments">Condiments</option>
                    <option value="Cooking Oil">Cooking Oil</option>
                    <option value="Rice">Rice</option>
                    <option value="Eggs">Eggs</option>
                    <option value="Dairy">Dairy</option>

                    <!-- Fruits & Vegetables -->
                    <option value="Fruits">Fruits</option>
                    <option value="Vegetables">Vegetables</option>

                    <!-- Personal Care -->
                    <option value="Personal Care">Personal Care</option>
                    <option value="Soap">Soap</option>
                    <option value="Shampoo">Shampoo</option>
                    <option value="Toothpaste">Toothpaste</option>
                    <option value="Skincare">Skincare</option>
                    <option value="Cosmetics">Cosmetics</option>

                    <!-- Household -->
                    <option value="Household Items">Household Items</option>
                    <option value="Cleaning Supplies">Cleaning Supplies</option>
                    <option value="Laundry">Laundry</option>
                    <option value="Kitchenware">Kitchenware</option>

                    <!-- School & Office -->
                    <option value="School Supplies">School Supplies</option>
                    <option value="Office Supplies">Office Supplies</option>
                    <option value="Books">Books</option>
                    <option value="Pens">Pens</option>
                    <option value="Paper">Paper</option>

                    <!-- Electronics -->
                    <option value="Electronics">Electronics</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Chargers">Chargers</option>
                    <option value="Headphones">Headphones</option>

                    <!-- Clothing -->
                    <option value="Clothing">Clothing</option>
                    <option value="Men Clothing">Men Clothing</option>
                    <option value="Women Clothing">Women Clothing</option>
                    <option value="Kids Clothing">Kids Clothing</option>
                    <option value="Footwear">Footwear</option>

                    <!-- Health -->
                    <option value="Medicine">Medicine</option>
                    <option value="Vitamins">Vitamins</option>
                    <option value="Medical Supplies">Medical Supplies</option>

                    <!-- Pet -->
                    <option value="Pet Food">Pet Food</option>
                    <option value="Pet Supplies">Pet Supplies</option>

                    <!-- Others -->
                    <option value="Miscellaneous">Miscellaneous</option>

                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/category/category.js') ?>"></script>
<?= $this->endSection() ?>