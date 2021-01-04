<template> 
  <div v-if="fields.length > groupOverflow">
    <default-field  
      :field="field" 
      :errors="errors" 
      :show-help-text="false" 
      :full-width-content=true  
    >

      <template slot="field" class="flex-col">
        <div class="flex flex-wrap -mt-2">
          <div 
            class="py-4 mr-4"
            role=button
            v-for="(field, index) in fields"
            @click="displayField(field)"
            :class="{'btn text-info': isActive(field)}"
          >
          {{ field.name }}&nbsp;<span
            v-if="field.required"
            class="text-danger text-sm"
            >{{ __('*') }}</span> 
          </div>
        </div>

        <component
          v-for="(field, index) in fields"
          :key="index"
          :is="`form-${field.component}`"
          :errors="errors"
          :resource-id="resourceId"
          :resource-name="resourceName"
          :field="field"
          :via-resource="viaResource"
          :via-resource-id="viaResourceId"
          :via-relationship="viaRelationship"
          :shown-via-new-relation-modal="shownViaNewRelationModal"
          @field-changed="$emit('field-changed')"
          @file-deleted="$emit('update-last-retrieved-at-timestamp')"
          @file-upload-started="$emit('file-upload-started')"
          @file-upload-finished="$emit('file-upload-finished')"
          :show-help-text="field.helpText != null" 
          class="remove-field-defaults"
          v-show="isActive(field)"
          ref="withoutLabel"
        />
      </template>
    </default-field> 
  </div>

  <div v-else>
    <component
      v-for="(field, index) in fields"
      :key="index"
      :is="`form-${field.component}`"
      :errors="errors"
      :resource-id="resourceId"
      :resource-name="resourceName"
      :field="field"
      :via-resource="viaResource"
      :via-resource-id="viaResourceId"
      :via-relationship="viaRelationship"
      :shown-via-new-relation-modal="shownViaNewRelationModal"
      @field-changed="$emit('field-changed')"
      @file-deleted="$emit('update-last-retrieved-at-timestamp')"
      @file-upload-started="$emit('file-upload-started')"
      @file-upload-finished="$emit('file-upload-finished')"
      :show-help-text="field.helpText != null"   
    />
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data: () => ({
    active:null
  }),  

  mounted() { 
  this.removeReferencedLabels() 
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.displayField(this.fields[0]) 
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      this.fields.forEach((field) => field.fill(formData)) 
    },

    displayField(field) {
      this.active = field
    },

    isActive(field) {
      return  this.active == field;
    },

    removeReferencedLabels() {
      this.$refs.withoutLabel.forEach(el => {
        el.$el.querySelector('label').parentElement.style.display = `none`
      })
    }
  }, 

  computed: {
    fields() {
      var fields = this.field.fields;

      fields.forEach((field) => field.fill = () => '') 

      return fields;
    },

    groupOverflow() {
      return this.field.groupOverflow ? this.field.groupOverflow : 0;
    },
  },
}
</script>
<style>
.remove-field-defaults {
  border: none;
}
.remove-field-defaults.hidden {
  display: none;
} 
.remove-field-defaults > div:nth-child(2) {
  width: 60% !important;
  padding: 0 !important;
}
</style>