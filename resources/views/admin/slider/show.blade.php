  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">

        <h3 class="profile-username text-center">
            {{ $slider->title }}
        </h3>
        @if(!empty($slider->image))
            <div class="text-center">
                <img class="img-fluid img-fit"
                    src="{{ asset('uploads/sliders/'.$slider->image) }}"
                    alt="slider">
            </div>
        @endif

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $slider->status == 1 ? "success":"danger" }}">{{ $slider->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>

            <li class="list-group-item">
                <b>Subtitle </b>
                <a class="float-right">
                    {{ $slider->subtitle ?? "" }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Description</b>
                <a class="float-right">
                    {{ $slider->description }}
                </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
