<template>
    <div>
        <div class="add-new-data-sidebar ps--scrolling-y"
             :style="sidebarWidth ? 'width: '+sidebarWidth+'px' : ''">
            <div class="overlay-bg dark-backdrop show"></div>
            <div class="add-new-data show" style="overflow: auto">
                <component :is="sidebarComponent"
                           :data="data"
                           :user_role="user_role"
                           @refreshData="refreshData"
                           @closeSidebar="closeSidebar"></component>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'right-sidebar',
    props: ['sidebarComponent', 'data','user_role', 'sidebarWidth'],
    methods: {
        refreshData()
        {
            this.$emit('refreshData');
        },
        closeSidebar()
        {
            this.$emit('closeSidebar');
        }
    }
}
</script>
