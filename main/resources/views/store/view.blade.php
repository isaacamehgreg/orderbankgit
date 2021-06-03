@include('store.store_header')
<style>

    .centered {
      position: absolute;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    </style>
    <body class="container">

    <!-- Header -->
    <div class="bg-primary p-3" style="background: {{ $store->store_header_color }} !important;">
        <div class="row">
            <div class="col-sm-5">
                <a href="{{ url('store/i/'.$store->store_url_slug) }}">

                    @if(isset($store->store_logo))
                        <img src="/uploads/store/logo/{{ $store->store_logo }}" alt="{{ $store->store_title }}" style="height: 50px;" />
                    @else
                        <img src="/ORDERBANK%20IDENT%20logo%20white.png?vc=2" alt="{{ $store->store_title }}" style="height: 50px;" />
                    @endif
                </a>
            </div>
            <div class="col-sm-2">

            </div>

            <div class="col-sm-4">
                <form action="?search=true">
                @csrf
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input name="query" type="text" class="form-control" placeholder="Search">
                  </div>
                </form>
            </div>
        </div>
    </div>
    <div class="p-0">
        @if(isset($store->store_banner_image))



            <style>
                .jumbotron {
                    color: white;
                    background-image: url("/uploads/store/logo/{{ $store->store_banner_image }}");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                    height: 100px;
                }
</style>
            <div class="jumbotron jumbotron-fluid" style="height: 493px;">
                <div class="container" style="margin-top: 200px;">
                  <p class="text-center" style="font-size: 20px;">{{ $store->store_banner_text }}</p>
                </div>
              </div>


        @endif
    </div>
    <div class="p-2" style="border: 2px solid {{ $store->store_header_color }}">
        <!-- Content -->
        <div class="container">
            <div class="row">
            @if(count($items) > 0)
                @foreach($items as $item)
                    <div class="col-md-3 mt-4 col-xs-4">
                        <div class="card profile-card-5">
                            <div class="card-img-block">
                                <img class="card-img-top mobileimg" src="/uploads/store/items/{{ $item->item_featured_image }}" alt="Item featured image">
                            </div>
                            <div class="card-body pt-0">
                            <h5 class="card-title">₦{{ number_format($item->item_amount) }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::words($item->item_name, 10,'...') }}</p>
                            <a href="{{ url('store/i/'.$store->store_url_slug.'/'.$item->id.'/'.str_slug($item->item_name)) }}" class="btn btn-danger">ORDER NOW</a>
                        </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>The Store Is Empty</h3>
            @endif
            </div>
            {{ $items->links() }}
        </div>
    </div>

    @include('store.store_footer')
    <script>

</script>
