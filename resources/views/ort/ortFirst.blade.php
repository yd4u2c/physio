p_comment" class="form-control">
					</div>

					<div class="form-group">
						<label>Are there any religious or cultural issues that we should be aware of regarding your child's evaluation?</label>
						<input type="text" name="religious" class="form-control">
					</div>

					<div class="form-group">
						<label>What goals are you hoping to have your child accomplish by partici[ating in Therapy?</label>
						<input type="text" name="goal" class="form-control">
					</div>

					<div class="checkbox">
						<label><input type="checkbox"> I have reviewed the information provided above and I found them to be accurate</label>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="{{ \Auth::User()->name }}" readonly required name="physio" class="form-control" id="exampleInputEmail1" />
					</div>

					<p>&nbsp;</p>
					<textarea name="info" placeholder="Additional Related information" class="form-control"></textarea>
					<p>&nbsp;</p>

					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   