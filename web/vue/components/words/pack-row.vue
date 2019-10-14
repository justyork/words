<template>
    <div style="margin-bottom: 3px;">

        <a :href="check_link" :class="'ui ' + (isRepeat ? 'blue' : (unlearned_words > 0 ? 'blue' : 'green')) +' button'" style="width: 165px">
            {{label}}
        </a>
        <div style="display: inline-block; margin-top: 5px">
            <span class="ui  buttons" >
                <a :href="learn_link+'ab'+afterLink" class="ui blue basic button icon">
                    <i class="arrow down icon"></i>
                </a>
                <a :href="learn_link+'ba'+afterLink" class="ui blue basic button icon">
                    <i class="arrow up icon"></i>
                </a>
                <a :href="learn_link+'r'+afterLink" class="ui teal button icon">
                    <i class="shuffle icon"></i>
                </a>
            </span>
            <span class="ui buttons">
                <button v-if="can_select" :class="'ui toggle button icon pack-row '+(isSelect ? 'active' : '')" @click="toggleRow">
                    <i class="check icon"></i>
                </button>
                <button :class="'ui toggle button icon ' +(isRepeat ? 'active' : '')" @click="changeRepeat"><i class="retweet icon"></i></button>
            </span>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ['pack_id', 'check_link', 'learn_link', 'label', 'can_select', 'unlearned_words'],
        data: function () {
            return {
                isSelect: false,
                isRepeat: false,
                afterLink: '',
            }
        },
        computed: {},
        methods: {
            changeRepeat(){
                this.isRepeat = !this.isRepeat
                this.afterLink = this.isRepeat ? '&rep' : ''

            },
            toggleRow(){
                this.isSelect = !this.isSelect;
                this.$emit('selectrow', this.pack_id)
            }
        }
    }
</script>