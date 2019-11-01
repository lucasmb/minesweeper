<template>
        <div class="row">
            <div class="minesweeper-game">
                <game-settings :rows="rows" :cols="cols" :mines="mines" @startGame="gameStart"></game-settings>
                <div  v-if="started" class="board">
                    <div class="row"  v-for="(row, x) in board" :key="x">
                        <mine-cell :cell="cell" :gameover="gameover" v-for="(cell, y) in row" :row="x" :key="y"
                                   @multiReveal="multiReveal"
                                   @gameOver="finishGame">
                        </mine-cell>
                    </div>

                </div>
                <div class="row">
                    00:00:00
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
            finishGame(){
                this.gameover=true;
                for(let i=0; i<this.rows; i++) {
                    for (let j = 0; j< this.cols; j++) {
                        this.board[i][j].revealed = true;
                    }
                }
            },
            multiReveal(cells){
                if(cells){
                    cells.forEach(function(el) {
                        console.log(el);
                        let cx=el[0]; let cy=el[1];
                        this.board[cx][cy].revealed = true;
                    }, this);
                }
                console.log(cells);
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped >
    .cell{
        border: solid 1px black;
        background: #8aabad;
        width: 40px;
        height: 40px;
        text-align: center;
    }
</style>
