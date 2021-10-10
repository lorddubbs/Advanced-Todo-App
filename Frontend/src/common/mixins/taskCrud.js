
    /*const taskCrud = store => ({
    });*/
    export default {
    methods: {
         async initiate() {
          try { 
              this.loader(true);
              let payload = {
                  'data': this.getPayload(),
                  'id': this.taskItems.id
              }
              await this.updateTask(payload);
              this.loader(false);
              this.$toast.info("Task Updated");
              this.$router.push({
                  name: 'tasks'
              });
              } catch (error) {
                  this.loader(false);
              }
      },
      getPayload() {
          let payload = new FormData();
          payload.append('_method', 'PUT');
          payload.append('title', this.taskItems.title);
          payload.append('description', this.description);
          payload.append('priority', this.taskItems.priority);
          payload.append('category_id', this.category_id);
          payload.append('start_date', this.start_date || '');
          payload.append('end_date', this.end_date || '');
          payload.append('thumbnail', this.thumbnail);
          payload.append('access', this.taskItems.access);
          return payload;
      },
      loader(args) {
        this.loading = args;
      }
    }
}