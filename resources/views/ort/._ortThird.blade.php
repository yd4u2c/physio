">
							</td>
						</tr>
					</table>
					<p>&nbsp;</p>
					<p>Does your child have any of the following conditions?</p>
					<div class="form-group">
						<label><input type="checkbox" name="describe[]" value="Mostly quite"> Mostly quite</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Tires easily"> Tires easily</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Talks constantly"> Talks constantly</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="clumsy"> clumsy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="happy"> happy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="impulsive"> impulsive</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="overly active"> overly active</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="overreacts frequently"> Overeact frequently</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="shy"> shy</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Restless"> restless</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Craves touch"> Craves touch</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Get frustrated easily"> Get frustrated easily</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="stubborn"> stubborn</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has temper tantrums"> Has temper tantrums</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Difficulty speaking"> Difficulty speaking</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has nervours habits"> Has nervours habits</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has unusual fears"> Has unusual fears</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Avoids touch"> Avoids touch</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Has poor attention span"> Has poor attention span</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="describe[]" value="Difficulty learning new task"> Difficulty in learning new task</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="describe[]" placeholder="Enter other here">&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="checkbox">
						<label><input type="checkbox" required> I have reviewed the information provided above and I found them to be complete</label>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Physiotherapist (Name)</label>
						<input type="text" value="{{ Auth::User()->name }}" readonly name="physio" required class="form-control" id="exampleInputEmail1" />
					</div>
					<p>&nbsp;</p>
					<textarea name="info" placeholder="Other related information" class="form-control"></textarea>
					<p>&nbsp;</p>

					<input type="submit" name="submit" class="btn btn-primary">

				</form>

			</div>
		</div>


	</div>
</div>
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         