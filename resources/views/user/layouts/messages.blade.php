
@if(count($errors) > 0)
    <div class="card-body">
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{$error}}')
            </script>
        @endforeach
    </div>
    <!-- /.card-body -->
@endif

@if (session('success'))
    <script>
        $(function () {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'success',
                title: '{{session('success')}}'
            })
        })
    </script>
@endif

@if (session('error'))
    <script>
        $(function () {
            toastr.error('{{session('error')}}')
        })
    </script>
@endif
