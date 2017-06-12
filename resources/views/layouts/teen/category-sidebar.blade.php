<div class="cat-side-box">
    <div class="box-title">
      <h3>{{tr('categories')}}</h3>
    </div>
    
    <div class="cat-side-box-cont">
        @foreach($categories as $category)
            <a href="{{route('user.category',$category->id)}}">{{$category->name}}</a>
        @endforeach
    </div>

</div>