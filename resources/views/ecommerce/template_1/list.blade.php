@php
    $category_id = request()->category;

    $products = \App\Models\Product::with(['rating', 'sales_details'])
                    ->whereRaw($category_id ? "products_category_id = $category_id" : 1)
                    ->withCount('sales_details')
                    ->orderBy('sales_details_count', 'desc')
                    ->where('deleted_at', NULL)->paginate(12);
    // dd($products);
@endphp

<div class="row">
    @forelse ($products as $item)
        @php
            $image = 'images/default.jpg';
            if($item->images){
                $image = 'storage/'.str_replace('.', '-cropped.', json_decode($item->images)[0]);
            }
        @endphp
        <div class="col-md-3 mb-3">
            <div class="card">
                <figure class="itemside">
                    <div class="aside">
                        <div class="img-wrap img-sm border-right">
                            <a href="{{ url('details/'.$item->slug) }}" title="{{ $item->name }}"><img src="{{ asset($image) }}" alt="{{ $item->name }}"></a>
                        </div>
                    </div>
                    <figcaption class="p-3">
                        <div style="height: 2.5em;overflow: hidden; text-overflow: ellipsis;">
                            <h6 class="title"><a href="{{ url('details/'.$item->slug) }}">{{ $item->name }}</a></h6>
                        </div>
                        <div class="price-wrap">
                            <span class="price-new b"><small>Bs.</small> {{ $item->price }}</span>
                            {{-- <del class="price-old text-muted">$1980</del> --}}
                        </div>
                    </figcaption>
                </figure> 
            </div>
        </div>

    @empty
        
    @endforelse

    <div class="col-md-12 mt-5 text-center" style="overflow: auto">
        {{ $products->links() }}
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