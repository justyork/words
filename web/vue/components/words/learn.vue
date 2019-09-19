<template>
    <div class="learn">
        <div class="learn-tip" v-if="hasAnswer">
            <a href="javascript:;" @click="tipForm = true" v-if="!tipForm">Add tip</a>
            <div v-if="tipForm">
                <input type="text" v-model="tipText">
                <button @click="saveTip" class="">OK</button>
            </div>
        </div>
        <div class="learn__item" v-if="words.length">
            <div class="learn__item-word">
                {{word}}
            </div>
            <div class="learn__item-translate" v-if="hasAnswer">
                {{translate}}
            </div>

            <div class="learn__item-tip" v-if="hasAnswer">
                {{words[0].tip}} &nbsp;
            </div>
        </div>

        <div class="learn-button">
            <div class="learn-button__start fluid ui buttons" v-if="wordStatus == 0">
                <a @click="know(false)" href="javascript:;" class="ui massive red button">DON'T KNOW</a>
                <a @click="know(true)" href="javascript:;" class="ui massive teal button">KNOW IT</a>
            </div>
            <div class="learn-button__know fluid ui buttons" v-if="wordStatus == 1">
                <a @click="correct(false)" href="javascript:;" class="ui massive red button">NOT CORRECT</a>
                <a @click="correct(true)" href="javascript:;" class="ui massive teal button">CORRECT</a>
            </div>
            <div class="learn-button__dontknow fluid ui buttons" v-if="wordStatus == 2">
                <a @click="correct(false)" href="javascript:;" class="ui massive blue button">NEXT</a>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: [
            'pack_id',
            'type'
        ],
        data: function () {
            return {
                apiUrl: '/api/',
                words: [],
                activeNum: 0,
                wordStatus: 0,
                isCorrect: false,
                hasAnswer: false,
                lastPosition: 0,
                halfPosition: 0,
                randomPos: -1,
                tipForm: false,
                tipText: '',
            }
        },
        computed:{
            word(){
                if(this.type == 'ab')
                    return this.words[0].word;
                if(this.type == 'ba')
                    return this.words[0].translate;
                if(this.type == 'r'){
                    return this.words[0].word;
                    // if(this.randomPos === -1) this.randomPos = Math.round(Math.random() * 10) >= 5;
                    // return this.randomPos ? this.words[0].word : this.words[0].translate;
                }
            },
            translate(){
                if(this.type == 'ab')
                    return this.words[0].translate;
                if(this.type == 'ba')
                    return this.words[0].word;
                if(this.type == 'r'){
                    return this.words[0].translate;
                    // if(this.randomPos === -1) this.randomPos = Math.round(Math.random() * 10) >= 5;
                    // return this.randomPos ? this.words[0].translate : this.words[0].word;
                }

            }
        },
        methods: {
            getWords(){
                this.$http.get(this.apiUrl+'words-by-pack?id='+this.pack_id).then(response => {
                    if(response.status){
                        this.words = response.body;
                        this.lastPosition = this.words.length - 1;
                        this.halfPosition = Math.ceil((this.words.length - 1) / 2)
                        if(this.type == 'r'){
                            var newArr = [];
                            this.words.forEach(function(element) {
                                element.randomPos = 'a';
                                newArr.push(element)
                                var el = Object.assign({}, element);
                                el.word = element.translate
                                el.translate = element.word
                                el.randomPos = 'b';

                                newArr.push(el)
                            })
                            console.log(newArr)

                            this.words = this.shuffle(newArr)
                        }
                    }
                })
            },
            nextWord(pos){
                this.words = this.move(this.words, pos);
                this.hasAnswer = false;
                this.isCorrect = false;
                this.wordStatus = 0;
                this.randomPos = -1;
                // console.log(this.words);
            },
            know(isTrue){
                this.hasAnswer = true;
                if(isTrue)
                    this.wordStatus = 1;
                else{
                    this.wordChecked(false);
                    this.wordStatus = 2;
                }
            },
            correct(isTrue){
                var pos = this.lastPosition;
                if(!isTrue)
                    pos = this.halfPosition;
                this.wordChecked(isTrue);
                this.nextWord(pos);
            },
            move(arr, new_index) {
                var old_index = 0;
                if (new_index >= arr.length) {
                    var k = new_index - arr.length + 1;
                    while (k--) {
                        arr.push(undefined);
                    }
                }
                arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
                return arr; // for testing
            },
            saveTip(){
                let data = new FormData();
                data.append('tip', this.tipText);
                data.append('word_id', this.words[0].id);
                this.$http.post(this.apiUrl+'add-word-tip', data ).then(response => {
                    if(response.status){
                        this.tipForm = false;
                        this.words[0].tip = this.tipText;
                    }
                })
            },
            wordChecked(correct){
                var pos = false;
                if(this.type === 'ab' || (this.type === 'r' && this.words[0].randomPos === 'a'))
                    pos = 'a';
                else if(this.type === 'ba' || (this.type === 'r' && this.words[0].randomPos === 'b'))
                    pos = 'b';

                let data = new FormData();
                data.append('word_id', this.words[0].id);
                data.append('correct', correct ? 1 : 0);
                data.append('type', pos);
                this.$http.post(this.apiUrl+'check-word', data )
            },
            shuffle(a) {
                var j, x, i;
                for (i = a.length - 1; i > 0; i--) {
                    j = Math.floor(Math.random() * (i + 1));
                    x = a[i];
                    a[i] = a[j];
                    a[j] = x;
                }
                return a;
            }
        },
        created: function () {
            if(!this.type) this.type = 'ab';
            this.getWords()
        }
    }
</script>

<style>
    .learn{
        text-align: center;
    }
    .learn__item{
        height: 250px;
        padding: 50px 20px;
        font-size: 25px;
    }
    .learn-tip{
        float: left;
        color: black;
        padding: 10px 20px;
    }
    .learn-tip a{
        color: black;
    }
    .learn-tip button{
        padding: 3px 5px;
        margin: 0;
        margin-top: -4px;
        background: #63DC90;
        color: white;
        border: none;
    }
    .learn__item>div{
        padding: 20px;
    }
    div.learn__item-tip{
        font-size: 16px;
        color: #c7c7c7;
        padding-bottom: 40px;
        padding-top: 0;
    }
    div.learn__item-word{
        padding-bottom: 40px;
    }
    div.learn__item-translate{
        padding-top: 40px;
        border-top: 1px solid #c3c3c3;
    }
    .learn-button{
        position: absolute;
        bottom: 30px;
        width: 100%;
        height: 60px;
        left: 0;
    }
    .learn-button>div{
        display: flex;
    }
    .learn-button a{
        flex: 1;
        display: block;
        vertical-align: middle;
        padding: 15px;
        text-align: center;
        width: 50%;
        font-size: 16px !important;
        /*color: white;*/
        /*border: 1px solid #906CD7;*/
        /*background: rgba(144, 108, 215, 0.30);*/

    }
    a.learn-button--red{
        color: #FF8B73;
        border: 1px solid #FF8B73;
    }
    a.learn-button--green{
        color: #63DC90;
        border: 1px solid #63DC90;
    }
    a.learn-button--left{
        border-right: none;
    }
    .learn-button--yellow{
        background: #906CD7;
    }
</style>