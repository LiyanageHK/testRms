@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Product</h2>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('admin/production/update/' . $product->id) }}" enctype="multipart/form-data">
        @csrf

        <!-- Product Details Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Product Info
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" {{ $product->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusSwitch">For Sale</label>
                </div>
            </div>
        </div>

        <!-- Product Sizes -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Size Multipliers
            </div>
            <div class="card-body row">
                <div class="col-md-4">
                    <label for="small" class="form-label">Small</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="small" id="small" class="form-control" value="{{ $product->small }}">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="medium" class="form-label">Medium</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="medium" id="medium" class="form-control" value="{{ $product->medium }}">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="large" class="form-label">Large</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="large" id="large" class="form-control" value="{{ $product->large }}">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing Images -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                Existing Images
            </div>
            <div class="card-body d-flex flex-wrap gap-3">
                @foreach($images as $img)
                    <div class="position-relative">
                        <img src="{{ asset('uploads/products/' . $img->image) }}" style="width:100px;" class="rounded shadow-sm">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="removeExistingImage('{{ $img->id }}')">X</button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- New Images Upload -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Add New Images
            </div>
            <div class="card-body">
                <input type="file" name="images[]" class="form-control" multiple onchange="previewImages(event)">
                <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                <div id="uploadedImagesCancel" class="mt-3"></div>
            </div>
        </div>

        <!-- Item Selection -->
        <div class="card mb-4">
            <div class="card-header bg-warning">
                Select Items & Quantities
            </div>
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Select</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="item_ids[]" value="{{ $item->id }}"
                                        {{ isset($selected[$item->id]) ? 'checked' : '' }}>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control" placeholder="Qty" min="1"
                                        value="{{ $selected[$item->id] ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary px-4">💾 Update Product</button>
        </div>
    </form>
</div>

<script>
    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreview');
        const cancelContainer = document.getElementById('uploadedImagesCancel');
        previewContainer.innerHTML = '';
        cancelContainer.innerHTML = '';

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('position-relative', 'me-2', 'mb-2');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.classList.add('rounded', 'shadow');

                const cancelButton = document.createElement('button');
                cancelButton.type = 'button';
                cancelButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                cancelButton.textContent = 'X';
                cancelButton.onclick = function() {
                    imgWrapper.remove();
                    const input = document.querySelector('input[name="images[]"]');
                    input.value = '';
                };

                imgWrapper.appendChild(img);
                imgWrapper.appendChild(cancelButton);
                previewContainer.appendChild(imgWrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeExistingImage(imageId) {
        if (confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: `/admin/production/image/delete/${imageId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        alert('Image deleted successfully.');
                        location.reload();
                    } else {
                        alert('Failed to delete the image.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the image.');
                }
            });
        }
    }
</script>
@endsection
