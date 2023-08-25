@extends('admin.layout.master')

@section('content')

    <style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 500px;
    }
    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }
    </style>

    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Post
                        <div class="page-title-subheading">
                            View, create, update, delete and manage.
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative row form-group">
                                <label for="post_type_id"
                                    class="col-md-3 text-md-right col-form-label">post_type</label>
                                <div class="col-md-9 col-xl-8">
                                    <select name="post_type_id" id="post_type_id" class="form-control">
                                        <option value="">-- Post type --</option>
                                        @foreach ($post_types as $post_type)
                                             <option {{ old('post_type_id') == $post_type->id ? "selected" : "" }} value="{{$post_type->id}}">{{$post_type->name}}</option>   
                                        @endforeach
                                    </select>
                                    @error('post_type_id')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="position-relative row form-group">
                                <label for="title" class="col-md-3 text-md-right col-form-label">Title</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="title" id="title" placeholder="Title" type="text"
                                        class="form-control" value="{{old('title')}}">
                                    @error('title')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="content"
                                    class="col-md-3 text-md-right col-form-label">Content</label>
                                <div class="col-md-9 col-xl-8">
                                    <textarea class="form-control" name="content" id="editor" >{{old('content')}}</textarea>
                                    @error('content')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="position-relative row form-group">
                                <label class="col-md-3 text-md-right col-form-label">Thumbnail</label>
                                <div class="image-container mt-2">
                                    <input type="file" onchange="previewThumbnail(this)" class="thumbnail-input" name="thumbnail" accept="image/png, image/gif, image/jpeg, image/webp">
                                    <img class="preview-thumbnail" src="" style="width: 100px;">
                                    @error('thumbnail')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-2">
                                    <a href="{{route("post.index")}}" class="border-0 btn btn-outline-danger mr-1">
                                        <span class="btn-icon-wrapper pr-1 opacity-8">
                                            <i class="fa fa-times fa-w-20"></i>
                                        </span>
                                        <span>Cancel</span>
                                    </a>

                                    <button type="submit"
                                        class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-download fa-w-20"></i>
                                        </span>
                                        <span>Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script src="/assets/admin/js/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush

@endsection