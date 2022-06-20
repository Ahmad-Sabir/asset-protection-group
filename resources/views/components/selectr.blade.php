@pushOnce('style')
<link rel="stylesheet" href="{{ '/css/selectr.min.css' }}">
@endPushOnce

<div class="selectr-wrap">
    <select id="mySelect" class="form-select" multiple>
        <option value="">Martin Freeman</option>
        <option value="">Select 1</option>
        <option value="">Select 2</option>
    </select>
</div>

@pushOnce('script')
<script src="{{ asset('js/selectr.min.js') }}"  type="text/javascript"></script>
<script>
  new Selectr('#mySelect', {
    searchable: true,
  });
</script>
@endPushOnce
