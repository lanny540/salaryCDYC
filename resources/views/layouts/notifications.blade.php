@if (Session::has('success'))
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title blue-bg text-center">
                <h4>{{ Session::get('success') }}</h4>
                <div class="ibox-tools">
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title red-bg text-center">
                @foreach ($errors->all() as $error)
                    <P>{{ $error }}</P>
                @endforeach
                <div class="ibox-tools">
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
