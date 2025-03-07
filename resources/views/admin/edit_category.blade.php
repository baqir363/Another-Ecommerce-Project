<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
    <style type="text/css">
        .div_deg
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }
        input[type='text']
        {
            width: 400px;
            height: 50px;
        }
    </style>
  </head>
  <body>
   @include('admin.header')
    <div class="d-flex align-items-stretch">
      @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h1 style="color: white;">Update Category</h1>
            <div class="div_deg">
                <form action="{{ url('update_category',$data->id) }}" method="POST">
                    @csrf
                    <input type="text" name="category" value="{{ $data->category_name }}">
                    <input type="submit" class="btn btn-primary" value="Update Category">
                </form>
            </div>
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
   @include('admin.js')
  </body>
</html>
