export default {
    methods: {
        getFile(event) {
            this.thumbnail = event.target.files[0] || event.dataTransfer.files;
            return this.thumbnail;
         }
    }
}