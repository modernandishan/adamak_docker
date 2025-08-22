<ul class="treding-keywords list-inline mb-0 mt-3 fs-13">
    <li class="list-inline-item text-danger fw-semibold"><i class="mdi mdi-tag-multiple-outline align-middle"></i>
         آزمون های آدمک:
    </li>
    @foreach($test_categories as $test_category)
        <li class="list-inline-item">
            <a href="{{route('tests.category.show',$test_category->slug)}}" class="link-secondary">
                {{$test_category->title}}
                -
            </a>
        </li>
    @endforeach
</ul>
