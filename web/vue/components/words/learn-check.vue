<template>
    <div class="learn" v-touch:swipe="swipeHandler">
        <div class="learn-tip">
            <a href="javascript:;" @click="tipForm = true" v-if="!tipForm">Add tip</a>
            <div v-if="tipForm">
                <input type="text" v-model="tipText">
                <button @click="saveTip" class="">OK</button>
            </div>
        </div>
        <div class="learn__item" v-if="words.length">
            <div class="learn__item-word">
                {{words[activeNum].word}}
            </div>
            <div class="learn-skip">
                <a href="javascript:;" class="ui mini blue button " @click="skip">Skip</a>
            </div>
            <div class="learn__item-translate">
                {{words[activeNum].translate}}
            </div>

            <div class="learn__item-tip" >
                {{words[activeNum].tip}} &nbsp;
            </div>
        </div>
        <div class="learn-button">
            <div class="learn-button__know fluid ui buttons">
                <a @click="prev" href="javascript:;" class="ui massive blue button">PREV</a>
                <a @click="next" href="javascript:;" class="ui massive teal button">NEXT</a>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ['pack_id',],
        data: function () {
            return {
                apiUrl: '/api/',
                words: [],
                activeNum: 0,
                tipForm: false,
                tipText: '',
            }
        },
        computed:{
        },
        methods: {
            getWords(){
                this.$http.get(this.apiUrl+'words-by-pack?id='+this.pack_id).then(response => {
                    if(response.status)
                        this.words = response.body;
                })
            },
            swipeHandler(direction){
                console.log(direction);
                if(direction === 'left') this.next()
                else this.prev();

            },
            prev(){
                if(this.activeNum === 0) this.activeNum = this.words.length - 1;
                else this.activeNum--;
            },
            next(){
                if(this.activeNum === this.words.length - 1) this.activeNum = 0;
                else this.activeNum++;
            },
            skip(){
                let data = new FormData()
                data.append('word_id', this.words[this.activeNum].id)
                data.append('pack_id', this.pack_id)
                this.$http.post(this.apiUrl+'skip-word', data ).then(response => {
                    if(response.status){
                        console.log(response.data)
                        console.log(this.activeNum)
                        this.words[this.activeNum] = response.data;
                        var oldNum = this.activeNum;
                        this.activeNum = 0;
                        this.activeNum = oldNum;
                    }
                })
            },
            saveTip(){
                let data = new FormData()
                data.append('tip', this.tipText)
                data.append('word_id', this.words[this.activeNum].id)
                this.$http.post(this.apiUrl+'add-word-tip', data ).then(response => {
                    if(response.status){
                        this.tipForm = false;
                        this.words[this.activeNum].tip = this.tipText;
                    }
                })
            }
        },
        created: function () {
            this.getWords()

        }
    }
</script>

<style>
    .learn-nav{
        width: 100%;
        display: flex;
        margin: 20px 0;
    }
    .learn-nav a{
        flex: 1;
        text-align: center;
        padding: 10px;
        background: #c9c9c9;
        color: white;
        border-right: 1px solid white;
    }
    .learn-nav a:last-child{
        border-right: none;
    }

    .learn-skip{
        position: absolute;
        margin-top: 10px;
        padding: 0 !important;
    }
    .learn-skip a{
        font-size: 14px;
        color: black;
    }
</style>