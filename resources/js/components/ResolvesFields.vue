<script> 
export default { 
  methods: {
    /**
     * Resolve the component name.
     */
    resolveComponentName(field) {
      return field.prefixComponent
        ? 'detail-' + field.component
        : field.component
    }, 
  },
  computed:{
  	fields: function() {
  		return this.field.fields.filter(field => field.value || field.displayNullfields)
  	}
  }
}
</script>
