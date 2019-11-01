<template>
        <div class="row">
            <div class="minesweeper-game">
                <game-settings :rows="rows" :cols="cols" :mines="mines" @startGame="gameStart"></game-settings>
                <div  v-if="started" class="board">
                    BOARD
                </div>
            </div>
        </div>
</template>

<script>
    import GameSettings from "./GameSettings.vue";

    export default {
        name: "minesweeper",
        components: {
            GameSettings,
        },
        data() {
            return {
                board: null,
                rows: 10,
                cols: 10,
                mines: 10,
                started: false,
                gameover:false,
            }
        },

        methods: {
            gameStart(data){
                this.update(data)
                axios.get('/api/game/init', {
                    params: {
                        rows: rows.value,
                        cols: cols.value,
                        mines: mines.value
                    },
                })
                .then(response => {
                    this.started = true;
                    this.board = response.data.board;
                })
                .catch(error => {
                    console.log(error)
                });
            },
            update(data){
                this.rows=data.r;
                this.cols=data.c;
                this.mines=data.m;
                this.board=null;
                this.gameover=false;

            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
