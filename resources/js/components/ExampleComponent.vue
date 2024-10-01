<template>
    <!-- <vmodal name="Foo">This is an example</vmodal> -->
    <div class="main">
        
            <modal name="card-modal" width="30%" height="40%">
                <div class="modal-div">
                    <div class="title-div">
                    <label for="title">Title :</label>
                    <input class="title" type="text" id="title" v-model="title">
                    </div>
                    <input type="hidden" v-model="column_id">
                    <div class="des-div" v-if="card_model">
                        <label for="description">Description :</label>
                        <textarea v-model="card_description" class="title" name="desciption" id="desciption" cols="30" rows="2"></textarea>
                        <!-- <input type="text" class="title" id="description" v-model="card_description"> -->
                    </div>
                    
                    <div class="center-text">
                    <button v-if="card_model" @click="submit_card" >Submit</button>
                    <button v-if="!card_model" @click="submit_col" >Submit</button>
                    </div>
                </div>
            </modal>
        
        <button @click="addColumn($event)">Add Column</button>
        <!-- <button @click="exportt($event)">Export Db</button> -->
        <div class="export-div">
            <a href="/export">Export Db</a>
        </div>
        <div class="container-cus">
            
            
            <div class="Cards-col-main" :class="['col-'+col.id]" v-for="(col, index) in columns" :key="col.id">
                <div class="Cards-col">
                    <div class="Cards-col-header">
                        <h4 class="Cards-col-h">{{ col.title }}</h4>
                        <a href="#" class="close" @click="deletecolumn($event,col.id)"></a>
                        <button @click="addCard($event,col.id)">Add Card</button>
                    </div>
                    
                    <draggable class="list-group" :class="['col-'+col.id]" :list="col.cards" @end="onEnd" :columns="columns" :options='{group: "people"}'>
                        <div v-bind:class="['column-' + col.id,'card-'+card.id]" class="Card list-group-item"  @click="show($event,card.id)" v-for="(card, c) in col.cards" :key="card.id">
                            <div class="Card-header">
                                <h4 class="Card-header-h">{{card.title}}</h4>
                                <a href="#" class="close" @click="deletecard($event,card.id)"></a>
                            </div>
                        </div>
                    </draggable>
                    
                </div>
            </div>
            

	    </div>

        
    </div>
    
</template>

<script>
// import vmodal from 'vue-js-modal'
import vmodal from 'vue-js-modal/dist/ssr.nocss'
import 'vue-js-modal/dist/styles.css'

import draggable from "vuedraggable";
Vue.use(vmodal)
    export default {
        components: {
            draggable
        },
        data() {
            return {
                'title': '',
                'card_description': '',
                'column_id': '',
                'card_id': '',
                'card_model': false,
                'columns':[],
                'indexin':[],
                'from':'',
                'to':'',
                'item':'',
            }
        },
        
        mounted() {
            this.getColumns();
        },
        methods: {
            onEnd (e) {
                console.log(e.item.classList[3]);
                this.from = e.from.classList[1]
                this.to = e.to.classList[1]
                this.item = e.item.classList[3]
                this.indexin = [];
                let classList = [];
                classList = e.originalEvent.target.classList
                let elements = document.querySelectorAll("." + classList[2]);
                elements.forEach((item, index) => {
                    this.indexin.push(item.classList[3]);
                })
                axios.post('/card/indexing', {
                    indexing:this.indexin,
                    from:this.from,
                    to:this.to,
                    item:this.item,
                });
            },
            exportt (e) {
                axios.get('/export', {
                    
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getColumns () {
                axios.get('/column').then((response) => {
                    this.columns = response.data.columns;
                });
            },
            submit_card () {
                axios.post('/card', {
                    title: this.title,
                    id: this.card_id,
                    description: this.card_description,
                    column_id: this.column_id,
                })
                .then(function (response) {
                    console.log(response);
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
                this.getColumns();
                this.$modal.hide('card-modal');
            },
            submit_col () {
                axios.post('/column', {
                    title: this.title,
                })
                .then(function (response) {
                    console.log(response);
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
                this.getColumns();
                this.$modal.hide('card-modal');
            },
            show (e,id) {
                
                if(e.target.classList.contains('close')){
                    return
                }
                console.log(id);
                axios.get('/card/' + id).then((response) => {
                    this.title = response.data.card.title
                    this.card_description = response.data.card.description
                    this.column_id = response.data.card.column_id
                });
                this.card_id = id
                this.card_model = true;
                this.$modal.show('card-modal');
            },
            hide () {
                this.$modal.hide('card-modal');
            },
            addCard (e,id) {
                this.card_model = true;
                this.title = ''
                this.card_description = ''
                this.card_id = ''
                
                this.column_id = id
                this.$modal.show('card-modal');
            },
            addColumn (e) {
                this.card_model = false
                this.title = ''
                this.card_description = ''
                this.$modal.show('card-modal');
            },
            deletecard (e,id) {
                axios.delete('/card/' + id).then((response) => {
                    
                });
                this.getColumns();
            },
            deletecolumn (e,id) {
                axios.delete('/column/' + id).then((response) => {
                    
                });
                this.getColumns();
            }
        },
    }
</script>
<style>

</style>