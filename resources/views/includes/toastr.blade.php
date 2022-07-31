<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
#toast-container > .toast {
    max-width: 500px;
    width: 50%;
}
</style>
<script>
    toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true,
        "close-button":true,
        "positionClass": "toast-bottom-full-width",
    };
  // success message popup notification
  @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}",);
  @endif
  // info message popup notification
  @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
  @endif
  // warning message popup notification
  @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
  @endif
  // error message popup notification
  @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
  @endif

</script>

<script>
  // success message popup notification
  @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
  @endif
  // info message popup notification
  @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
  @endif
  // warning message popup notification
  @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
  @endif
  // error message popup notification
  @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
  @endif

</script>
