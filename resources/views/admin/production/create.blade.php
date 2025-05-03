@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🛒 Create Product </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('admin/production/store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Product Details Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Product Details
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Images (first = main)</label>
                    <input type="file" name="images[]" class="form-control" multiple required onchange="previewImages(event)">
                    <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                    <label class="form-check-label" for="statusSwitch">For Sale</label>
                </div>
            </div>
        </div>

        <!-- Sizes Card -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Product Sizes (Multiplier Values)
            </div>
            <div class="card-body row">
                <div class="col-md-4">
                    <label for="small" class="form-label">Small</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="small" id="small" class="form-control" value="1">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="medium" class="form-label">Medium</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="medium" id="medium" class="form-control" value="2">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="large" class="form-label">Large</label>
                    <div class="input-group">
                        <input type="number" step="0.5" name="large" id="large" class="form-control" value="3">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Selection Card -->
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
                        @foreach($items as $index => $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="item_ids[]" value="{{ $item->id }}">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <input type="number" name="quantities[]" class="form-control" placeholder="Qty" min="1">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-success px-4">✅ Create Product</button>
        </div>
    </form>
</div>

<script>
    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'shadow');
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection
