import { mapMutations } from 'vuex';

export default {
    methods: {
        ...mapMutations('breadcrumb', {
            setBreadcrumbs: 'set',
            pushBreadcrumb: 'push',
            popBreadcrumb: 'pop',
            replaceBreadcrumb: 'replace',
            emptyBreadcrumbs: 'empty'
        })
    }
}