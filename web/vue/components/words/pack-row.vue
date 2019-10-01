<template>
    <div style="margin-bottom: 3px;">
        <div class="ui  buttons">
            <a :href="check_link" class="ui blue button" style="width: 150px">
                {{label}}
            </a>
            <a :href="learn_link+'ab'" class="ui blue basic button icon">
                <i class="arrow down icon"></i>
            </a>
            <a :href="learn_link+'ba'" class="ui blue basic button icon">
                <i class="arrow up icon"></i>
            </a>
            <a :href="learn_link+'r'" class="ui teal button icon">
                <i class="shuffle icon"></i>
            </a>
        </div>

        <button v-if="can_select" :class="'ui toggle button icon pack-row '+(isSelect ? 'active' : '')" @click="toggleRow">
            <i class="check icon"></i>
        </button>
    </div>
</template>

<script>
    module.exports = {
        props: ['pack_id', 'check_link', 'learn_link', 'label', 'can_select'],
        data: function () {
            return {
                isSelect: false
            }
        },
        computed: {},
        methods: {
            toggleRow(){
                this.isSelect = !this.isSelect;
                this.$emit('selectrow', this.pack_id)
            }
        }
    }
</script>

<style scoped>

</style>