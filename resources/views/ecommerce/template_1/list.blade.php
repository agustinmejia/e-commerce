<div class="row">
    <div class="col-md-12">
        @php
            $category_id = request()->category;
            $brand_id = request()->brands;
            $min_price = request()->min_price;
            $max_price = request()->max_price;

            $products = \App\Models\Product::with(['rating', 'sales_details'])
                            ->whereRaw($category_id ? "products_category_id = $category_id" : 1)
                            ->whereRaw($brand_id ? "products_brand_id IN ($brand_id)" : 1)
                            ->whereRaw($min_price ? "price >=$min_price" : 1)
                            ->whereRaw($max_price ? "price <=$max_price" : 1)
                            ->withCount('sales_details')
                            ->orderBy('sales_details_count', 'desc')
                            ->where('deleted_at', NULL)->paginate(5);
            // dd($products);
        @endphp
        @forelse ($products as $item)
            @php
                $image = 'images/default.jpg';
                if($item->images){
                    $image = 'storage/'.str_replace('.', '-cropped.', json_decode($item->images)[0]);
                }
            @endphp
            <article class="card card-product">
                <div class="card-body">
                    <div class="row">
                        <aside class="col-sm-3">
                            <a href="{{ url('details/'.$item->slug) }}" title="Click para ver detalles">
                                <div class="img-wrap"><img src="{{ asset($image) }}" alt="{{ $item->name }}"></div>
                            </a>
                        </aside>
                        <article class="col-sm-6 mt-3">
                            <h4 class="title"> {{ $item->name }} | <small style="font-size: 15px">{{ $item->category->name }}</small> </h4>
                                <div class="rating-wrap  mb-2">
                                    <ul class="rating-stars">
                                        <li style="width:0%" class="stars-active"> 
                                            <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                        </li>
                                        <li>
                                            <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                            <i class="fa fa-star"></i> 
                                        </li>
                                    </ul>
                                    <div class="label-rating"> &nbsp; {{ $item->rating->count() }} reviews</div>
                                    <div class="label-rating">{{ $item->sales_details->count() }} Ventas </div>
                                </div>
                                {!! $item->long_description !!}
                            
                        </article>
                        <aside class="col-sm-3 border-left">
                            <div class="action-wrap">
                                <div class="price-wrap h4">
                                    <span class="price"> <small>Bs.</small> {{ number_format($item->price, 2, ',', '.') }} </span>	
                                    {{-- <del class="price-old"> $98</del> --}}
                                </div>
                                <p class="text-success">Envío gratis</p>
                                <p class="text-center">
                                    <a href="https://wa.me/{{ setting('social.whatsapp') ?? '59175199157' }}?text={{ url('details/'.$item->slug) }} Vi%20esto%20en%20tu%20sitio%20web" target="_blank" class="btn btn-success btn-block"><i class="fab fa-whatsapp"></i> &nbsp; WhastApp</a>
                                    <a href="{{ url('details/'.$item->slug) }}" class="btn btn-secondary btn-block"><i class="fas fa-list-alt"></i> &nbsp; Ver detalles</a>
                                </p>
                                <a href="#"><i class="fa fa-heart"></i> Me gusta</a>
                            </div>
                        </aside>
                    </div>
                </div>
            </article>
        @empty
        <article class="card card-product" style="height: 400px">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="text-center text-muted mt-5 mb-5">No hay productos</h4>
                        <img src="{{ asset('images/empty.png') }}" alt="empty" width="200px">
                    </div>
                </div>
            </div>
        </article>
        @endforelse
    </div>
    <div class="col-md-4">
        @if(count($products)>0)
            <p class="text-muted">Viendo del {{ $products->firstItem() }} al {{ $products->lastItem() }} de {{ $products->total() }} productos.</p>
        @endif
    </div>
    <div class="col-md-8">
        <nav class="float-right">{{ $products->links() }}</nav>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                list(page);
            }
        });
    });
</script>