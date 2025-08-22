<div class="p-3 mt-2">
    <h6 class="text-muted mb-3 text-uppercase fw-bold fs-13">دسته بندی های برتر وبلاگ آدمک</h6>

    <ol class="ps-3 text-muted">
        @foreach($topCategories as $category)
            <li class="py-1">
                <a href="{{ route('blog.category.show', $category->slug) }}" class="text-muted">
                    {{ $category->title }}
                    <span class="float-end">({{ number_format($category->posts_count) }})</span>
                </a>
            </li>
        @endforeach
    </ol>

    {{--<div class="mt-3 text-center">
        <a href="">
            مشاهده همه دسته ها
        </a>
    </div>--}}
</div>
