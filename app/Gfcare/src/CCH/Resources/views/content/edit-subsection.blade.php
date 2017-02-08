<div class="modal fade" id="modal-edit-subsection" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit SubSection</h4>
            </div>

            <div class="modal-body">
                <spark-error-alert :form="forms.updateSubSection"></spark-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <spark-select :display="'Section*'" :form="forms.updateSubSection" :name="'section_id'" :items="sectionOptions" :input.sync="forms.updateSubSection.section_id">
                    </spark-select>

                    <spark-text :display="'Name*'" :form="forms.updateSubSection" :name="'name'" :input.sync="forms.updateSubSection.name">
                    </spark-text>


                    <spark-file :display="'Icon file'" :form="forms.updateSubSection" :name="'icon_file'" :warning="'File must be less than 20MB. Must be an image file'" :filename.sync="forms.updateSubSection.file_name" :input.sync="forms.updateSubSection.icon_file">
                    </spark-file>

                </form>
                <fieldset>
                    <legend>Icon</legend>
                    <div class="panel-body" v-if="editingSubSection.icon_url">
                        <img v-bind:src="getImageUrl(editingSubSection)" />
                    </div>
                    <div v-else class="panel-body">
                        No uploads found.
                    </div>
                </fieldset>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click.prevent="addNewSubSection" :disabled="forms.updateSubSection.busy">
                    <span v-if="forms.updateSubSection.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                </button>
            </div>
        </div>
    </div>
</div>
