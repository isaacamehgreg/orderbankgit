@include('store.store_header')
    <body class="container">

   {{-- <!-- Header -->
    <div class="bg-primary p-3" style="background: {{ $store->store_header_color }} !important;">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ url('store/i/'.$store->store_url_slug) }}"><h2 class="cmobile text-center" style="color: {{ $store->store_font_color }};">{{ $store->store_title }}</h2></a>
            </div>
        </div>
    </div>
    <div class="p-2" style="border: 2px solid {{ $store->store_header_color }}">
        <!-- Content --> --}}
        <div class="container text-center">
            <div class="">
               {{-- <br>
                <h1><b style="color:red;">{{ $item->item_name }}</b></h1>
                <br>
                <center><img class="card-img-top img-responsive" style="max-width: 500px;" style="align-items: center" src="/uploads/store/items/{{ $item->item_featured_image }}" alt="Item featured image"></center>
                <br>

                <br>
                <h2>Today's Price: <b style="color:red;">₦{{ number_format($item->item_amount) }}</b></h2>
                <br> --}}
                                <center>	                <h3>{!! $item->item_description !!}</h3>
                    @if(isset($form->link))
                    <iframe src="{{ url('form/'.$form->link) }}" style="border: none;width: 100%; height: 2000px;"></iframe>
                    @endif <br>
                </center>
            </div>
        </div>
    </div>
    @include('store.store_footer')
