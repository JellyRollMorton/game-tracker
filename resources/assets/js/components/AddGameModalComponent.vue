<template>

    <div class="modal fade" id="add-game-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Game</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label for="player1-select">Player 1</label>
                            <select class="form-control" id="player1-select">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="player2-select">Player 2</label>
                            <select class="form-control" id="player2-select">
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

            this.enablePlayerSearchSelect2($("#player1-select"));
            this.enablePlayerSearchSelect2($("#player2-select"));
        },
        methods: {
            enablePlayerSearchSelect2: function(selectElement) {

                selectElement.select2({
                    width: '100%',
                    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                        url: "/api/players/search",
                        dataType: 'json',
                        quietMillis: 250,
                        data: function(term, page) {
                            return {
                                q: term, // search term
                            };
                        },
                        results: function(data, page) { // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to alter the remote JSON data
                            return {
                                results: data.items
                            };
                        },
                        cache: true
                    },
                    theme: "bootstrap"
                });
            }
        }
    }
</script>