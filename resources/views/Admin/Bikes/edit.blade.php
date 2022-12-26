@extends('layouts.admin-layout')
@section('bike-active')
    active
@endsection
@section('style')
    <style>
        .table thead th {
            padding: .5rem;
        }

        #preview-image {
            max-width: 200px;
            margin: 1rem 0;
        }

        form {
            max-width: 700px;
            display: block;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 1rem 2rem;
            border-radius: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-item-center justify-content-between">
                    <h5>Edit Bike</h5>
                    <a href="" class="btn btn-sm btn-primary d-flex gap-2 px-3 back-btn">
                        <i class="fas fa-undo "></i>
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bikes.update', $bike->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5 class="my-3 text-center">Complete the form</h5>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $bike->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Categories</label>
                            <select name="category" id=""
                                class="form-select @error('category') is-invalid @enderror">
                                <option value="">Select Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category') == $category->id || $bike->category_id == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Brands</label>
                            <select name="brand" id="" class="form-select @error('brand') is-invalid @enderror">
                                <option value="">Select Categories</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if (old('brand') == $brand->id || $bike->brand_id == $brand->id) selected @endif>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                                value="{{ old('qty', $bike->qty) }}">
                            @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Price Per Day (MMK)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $bike->price) }}">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control-file  @error('photo') is-invalid @enderror"
                                id="photo" name="photo" value="{{ old('photo') }}" id="photo">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <img src="{{ asset($bike->photo) }}" alt="" id="preview-image">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="desc" id="description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc', $bike->desc) }}</textarea>
                            @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#photo').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            ClassicEditor
                .create(document.querySelector('#description'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption',
                        'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed', 'Table', 'BlockQuote',
                    ],
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
