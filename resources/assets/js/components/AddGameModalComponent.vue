<template>

<div class="modal fade" id="add-game-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Player 1</label>
            <select class="form-control player1-select">
          <option>orange</option>
          <option>white</option>
          <option>purple</option>
        </select>
  </div>
</form>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')            

            $(".player1-select").select2({
              tags: true,
              width: '100%',
                ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                    url: "/api/players/search",
                    dataType: 'json',
                    quietMillis: 0,
                    data: function (term, page) {
                        return {
                            q: term, // search term
                        };
                    },
                    results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter the remote JSON data
                        console.log(data);
                        return { results: data.items };
                    },
                    cache: true
                },              
              theme: "bootstrap",
              createTag: function(params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                console.log(term);
                console.log(params);
                return {
                  id: term,
                  text: term,
                  newTag: true // add additional parameters
                }
              },
              select: function(params) {
                console.log('selected!');
                console.log(params);
              }
            });

            $('.player1-select').on('select2:select', function (e) {
                if (e.params.data.newTag) {
                    //e.params.data.id = 'x';
                    console.log('new!!');
                    console.log(e.params.data);
                }
            });


        },
        methods: {
            select: function(event) {
                console.log('yoyoo');
            }
        }
    }
</script>
