@php



$product_name = old('v')??$product->product_name??"";
$category_id = old('category_id')??$product->category_id??"";
$subcategory_id = old('subcategory_id')??$product->subcategory_id??"";
$brand_id = old('brand_id')??$product->brand_id??"";
$quantity = old('quantity')??$product->quantity??"";
$price = old('price')??$product->price??"";
$selling_price = old('selling_price')??$product->selling_price??"";

$action = (isset($product))?route('product.update', $product->id):route('product.store');

@endphp
<form method="post" action="{{ $action }}">
    @csrf

    @if(isset($product))
        @method('put')
    @endif

        <div class="mb-3">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product_name }}" required>
        </div>

        <div class="mb-3">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $quantity }}" required>
        </div>

        <div class="mb-3">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $price }}" required>
        </div>

        <div class="mb-3">
            <label for="sellingPrice">Selling Price:</label>
            <input type="text" class="form-control" id="sellingPrice" name="sellingPrice" value="{{ $selling_price }}" required>
        </div>

        <div class="mb-3">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == $category_id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="subcategory">Subcategory:</label>
            <select class="form-control" id="subcategory" name="subcategory" required>
                <option value="">Select Subcategory</option>
                @if(isset($subcategories))
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" @if($subcategory->id == $subcategory_id) selected @endif>{{ $subcategory->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3">
            <label for="brand">Brand:</label>
            <select class="form-control" id="brand" name="brand" required>
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @if($brand->id == $brand_id) selected @endif>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="variantList">
            <div id="variantFields">
                <div class="variantTypeSelect_1">
                    <label for="variantType_1">Variant Type:</label>
                    <select id="variantType_1" name="variant[0][type]" class="form-control variantType variantType_1">
                        <option value="">Select Variant Type</option>
                        <option value="color">Color</option>
                        <option value="size">Size</option>
                    </select>
                </div>
                <div class="variant variant_1 d-none">
                    <div class="select-color">
                        <label for="color">Color:</label>
                        <select class="form-control color" name="variant[0][color]">
                            <option value="red">Red</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                        </select>
                    </div>
                    <div>
                        <label for="sizes">Sizes:</label>
                        <select class="form-control sizes" name="variant[0][sizes][]" multiple>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <div>
                        <label for="quantity">Quantity:</label>
                        <input class="form-control quantity" type="number" name="variant[0][quantity]">
                    </div>
                    <div>
                        <label for="price">Price:</label>
                        <input class="form-control price" type="text" name="variant[0][price]">
                    </div>
                    <div>
                        <label for="sellingPrice">Selling Price:</label>
                        <input class="form-control sellingPrice" type="text" name="variant[0][sellingPrice]">
                    </div>
                </div>
                @if(isset($product))
                    @foreach($product->variants as $key => $variant)
                        <input type="hidden" name="variant[{{$key+1}}]['variant_id']" value="{{ $variant->id }}">
                        <hr>
                        <div class="variant">
                            <div>
                                <label for="variantType">Variant Type:</label>
                                <select name="variant[{{$key+1}}][type]" class="form-control variantType">
                                    <option value="">Select Variant Type</option>
                                    <option value="color" @if($variant->variant_type == 'color') selected @endif>Color</option>
                                    <option value="size" @if($variant->variant_type == 'size') selected @endif>Size</option>
                                </select>
                            </div>
                            <div class="select-color">
                                <label for="color">Color:</label>
                                <select class="form-control color" name="variant[{{$key+1}}][color]">
                                    <option value="">-- Select Color --</option>
                                    <option value="red" @if($variant->color == 'red') selected @endif>Red</option>
                                    <option value="green" @if($variant->color == 'green') selected @endif>Green</option>
                                    <option value="blue" @if($variant->color == 'blue') selected @endif>Blue</option>
                                </select>
                            </div>
                            <div>
                                <label for="sizes">Sizes:</label>
                                @php
                                    $sizes = ($variant->size)?json_decode($variant->size):[];
                                @endphp
                                <select class="form-control sizes" name="variant[{{$key+1}}][sizes][]" multiple>
                                    <option value="S" @if(in_array('S', $sizes)) selected @endif>S</option>
                                    <option value="M" @if(in_array('M', $sizes)) selected @endif>M</option>
                                    <option value="L" @if(in_array('L', $sizes)) selected @endif>L</option>
                                    <option value="XL" @if(in_array('XL', $sizes)) selected @endif>XL</option>
                                </select>
                            </div>
                            <div>
                                <label for="quantity">Quantity:</label>
                                <input class="form-control quantity" type="number" name="variant[{{$key+1}}][quantity]" value="{{ $variant->quantity }}">
                            </div>
                            <div>
                                <label for="price">Price:</label>
                                <input class="form-control price" type="text" name="variant[{{$key+1}}][price]" value="{{ $variant->price }}">
                            </div>
                            <div>
                                <label for="sellingPrice">Selling Price:</label>
                                <input class="form-control sellingPrice" type="text" name="variant[{{$key+1}}][sellingPrice]" value="{{ $variant->selling_price }}">
                            </div>
                                <button class="btn btn-sm btn-primary removeVariant">Remove</button><br><br>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" class="btn btn-sm btn-primary d-none" id="addVariant">Add More</button>
        </div>

        <br>
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Save Product</button>
        </div>
    </form>

    @push('footer')

    <script>
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            var subcategoryDropdown = $('#subcategory');
            subcategoryDropdown.empty();
            subcategoryDropdown.append($('<option>', {
                value: '',
                text: 'Select Subcategory'
            }));
            if (categoryId !== '') {
                $.ajax({
                    url: '{{ url("/") }}/category/' + categoryId + '/subcategories',
                    method: 'GET',
                    success: function(response) {
                        $.each(response, function(index, subcategory) {
                            subcategoryDropdown.append($('<option>', {
                                value: subcategory.id,
                                text: subcategory.name
                            }));
                        });
                    }
                });
            }
        });

       
        $('#variantType_1').on('change', function() {
            var variantType = $(this).val();
            if(variantType) {
                $('.variant_1').removeClass('d-none');
                $('#addVariant').removeClass('d-none');
            } else {
                $('.variant_1').addClass('d-none');
                $('#addVariant').addClass('d-none');
            }

            if (variantType === 'size') {
                $(this).parents('.variantTypeSelect_1').next('.variant_1').find('.select-color select').val("");
                $(this).parents('.variantTypeSelect_1').next('.variant_1').find('.select-color').hide();
            } else {
                $(this).parents('.variantTypeSelect_1').next('.variant_1').find('.select-color').show();
            }

        });

        $(document).on('change', '.variantType', function() {
            var variantType = $(this).val();
            if (variantType === 'size') {
                $(this).parents('.variant').find('.select-color select').val("");
                $(this).parents('.variant').find('.select-color').hide();
            } else {
                $(this).parents('.variant').find('.select-color').show();
            }
        });

        var variantCounter = `{{ (isset($product))?$product->variants->count()+1:1 }}`;
        $('#addVariant').on('click', function() {
            var variantFields = $('#variantFields');

            var variantHTML = `
                <hr>
                <div class="variant">
                    <div>
                        <label for="variantType">Variant Type:</label>
                        <select name="variant[${variantCounter}][type]" class="form-control variantType">
                            <option value="">Select Variant Type</option>
                            <option value="color">Color</option>
                            <option value="size">Size</option>
                        </select>
                    </div>
                    <div class="select-color">
                        <label for="color">Color:</label>
                        <select class="form-control color" name="variant[${variantCounter}][color]">
                            <option value="red">Red</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                        </select>
                    </div>
                    <div>
                        <label for="sizes">Sizes:</label>
                        <select class="form-control sizes" name="variant[${variantCounter}][sizes][]" multiple>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <div>
                        <label for="quantity">Quantity:</label>
                        <input class="form-control quantity" type="number" name="variant[${variantCounter}][quantity]">
                    </div>
                    <div>
                        <label for="price">Price:</label>
                        <input class="form-control price" type="text" name="variant[${variantCounter}][price]">
                    </div>
                    <div>
                        <label for="sellingPrice">Selling Price:</label>
                        <input class="form-control sellingPrice" type="text" name="variant[${variantCounter}][sellingPrice]">
                    </div>
                        <button class="btn btn-sm btn-primary removeVariant">Remove</button><br><br>
                </div>`;

            variantFields.append(variantHTML);
            variantCounter++;
        });

        $(document).on('click', '.removeVariant', function() {
            $(this).closest('.variant').remove();
            variantCounter--;
        });

    </script>

    @endpush