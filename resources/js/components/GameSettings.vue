<template>
    <form>
        <div class="form-row align-items-center">
        <div class="col-lg-8">
            <div class="form-group ">
                <label for="rows">Rows</label>
                <div class="controls">
                    <div class="input-prepend input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >R</span>
                    </div>
                    <input id="rows" type="number" v-model.number="localRows" min="1" >
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="rows">Cols</label>
                <div class="controls">
                    <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >C</span>
                        </div>
                        <input id="cols" type="number"  v-model.number="localCols" min="1" >
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="rows">Mines</label>
                <div class="controls">
                    <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >M</span>
                        </div>
                        <input id="mines" type="number" v-model.number="localMines" min="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="">
                <button class="btn btn-lg btn-primary" @click.prevent="$emit('startGame', {r:localRows, c:localCols, m:localMines})">Play</button>
            </div>
        </div>
        </div>
    </form>
</template>

<script>
    export default {
        name: "GameSettings",
        props : {
            rows: Number,
            cols: Number,
            mines: Number,
        },
        methods: {
        },
        data (){
            return {
                localRows: this.rows,
                localCols:this.cols,
                localMines : this.mines,
            }
        },
    }
</script>

<style scoped>

</style>
