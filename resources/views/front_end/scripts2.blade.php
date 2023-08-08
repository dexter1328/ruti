<script type="text/javascript">
    var route = "{{ url('/shop/search/autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
      return $.get(route, { term: query }, function (data) {
              return process(data);
          });
      }
    },
      {
        hint: true,
        highlight: true,
        minLength: 1
        },
      );
</script>
