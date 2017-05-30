<gfcare-mm-system-config-screen :team-id="{{ $team->id }}" inline-template>

    <!-- Config -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Configuration
        </div>

        <div class="panel-body">
        	<form class="form-horizontal" role="form">
            	<spark-text :display="'SMS Link'"
                            :form="forms.updateForm"
                            :name="'sms'"
                            :input.sync="forms.updateForm.sms">
                </spark-text>
            	<spark-text :display="'Voice Link'"
                            :form="forms.updateForm"
                            :name="'voice'"
                            :input.sync="forms.updateForm.voice">
                </spark-text>
            </form>
            </form>
        </div>
		<div class="panel-footer">
            <button type="button" class="btn btn-primary pull-right" @click.prevent="updateConfig()" :disabled="forms.updateForm.busy">
            	<span v-if="forms.updateForm.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
             </button>
        </div>
    </div>
    
</gfcare-mm-system-config-screen>
