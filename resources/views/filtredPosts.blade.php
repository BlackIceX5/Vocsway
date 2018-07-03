@foreach ($posts as $post)
    <div class="item photo">
        <div class="item-content">
            <div class="item-shadow"></div>

            <div class="item-image img-thumbnail " data-src="{{ $post->main_img }}" alt="{{ $post->title }}"></div>
            <div class="item-gradient"></div>
            <a href="{{ route('post', ['id'=>$post->id]) }}" class="ajax-link" data-type="page-transition">
                <div class="item-caption">

                    <h2 class="item-title">{{ $post->title }} </h2>
                    <h3 class="item-sub-mask">
                        <span class="item-cat">{{ $post->category }} {{ $post->date }}</span>
                        <span class="item-case">View Details</span>
                    </h3>

                    <div class="item-sub-mask ">
                        <i class="item-cat fas fa-eye blogInfo">{{ $post->visits}}</i>
                        <i class="item-cat fas fa-thumbs-up blogInfo">{{ $post->likes}}</i>
                        <i class="item-cat fas fa-comments blogInfo">{{ $post->comments}}</i>
                    </div>
                </div>
            </a>
            <div class="col-md-12 text-center voteCarDesc top100" >

                <p class="mainPostContent">{{ $post->content }}</p>

            </div>
        </div>

    </div>
@endforeach