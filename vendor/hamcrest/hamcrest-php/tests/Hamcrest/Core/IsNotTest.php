<!-- $FIELD_NAME_TITLE$ Field -->
<div class="form-group col-sm-6">
    <label for="$FIELD_NAME$">$FIELD_NAME_TITLE$:</label>
	<select v-model="row.$FIELD_NAME$" v-validate:$FIELD_NAME$="{ required: true, minlength: 3, maxlength: 128 }">
		<option v-for="option in options" v-bind:value="option.value">
			@{{ option.text }}
		</option>
	</select>
    <div v-if="$validation.$FIELD_NAME$.invalid" class="alert alert-danger" role="alert">
		<div v-if="$validation.$FIELD_NAME$.required"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			El código es obligatorio
		</div>
		<div v-if="$validation.$FIELD_NAME$.minlength">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			Longitud mínima erronea					
		</div>
	</div>    
</div>                                                                                                                               