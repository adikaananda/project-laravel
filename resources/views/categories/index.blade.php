@extends('layouts.app')

@section('content')
<div class="min-w-[1102px]">
  <!-- table header start -->
  <div class="grid grid-cols-11 px-5 py-3 sm:px-6">
    <div class="col-span-3 flex items-center">
      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
        Name
      </p>
    </div>
    <div class="col-span-2 flex items-center">
      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
        Created Date
      </p>
    </div>
    <div class="col-span-2 flex items-center">
      <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
        Action
      </p>
    </div>
  </div>
  <!-- table header end -->

  <!-- table body start -->

  @foreach ($categories as $category)
  <!-- table item -->
  <div class="grid grid-cols-11 border-t border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6">
    <div class="col-span-3 flex items-center">
      <div class="flex items-center gap-3">
        <div>
          <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
            {{$category->name}}
          </span>
        </div>
      </div>
    </div>
    <div class="col-span-2 flex items-center">
      <p class="text-theme-sm text-gray-500 dark:text-gray-400">
        {{$category->created_at}}
      </p>
    </div>
    <div class="col-span-2 flex items-center">
      <a href="{{ route('products.edit', $category->id) }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-eye">
          <path
            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
          <circle cx="12" cy="12" r="3" />
        </svg>
      </a>

      <form method="POST" class="btn-category-delete" action="{{ route('products.destroy', $category->id) }}">
        @csrf
        @method('DELETE')
        <button>
          <svg class="cursor-pointer fill-gray-700 hover:fill-error-500 dark:fill-gray-400 dark:hover:fill-error-500"
            width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
              fill=""></path>
          </svg>
        </button>
      </form>
    </div>
  </div>
  @endforeach


  <!-- table body end -->
</div>

@endsection


@section('scripts')
<script>
  $(document).ready(function(){
    $('.btn-category-delete').on('click', function(e) {
      e.preventDefault();

      Swal.fire({
        title: "Are you sure?",
        text: "This will permanently delete the category!",
        icon: "warning",
        showCancelButton:true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).closest('form').submit()
        }
      })
    })
  })
</script>
@endsection