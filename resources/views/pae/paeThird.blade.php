tr>
            <tr>
              <td style="width: 200px;">Sit<input type="text" name="issue[]" value="Sit" style="display: none;"><input type="text" name="tp[]" value="Balance dynamic" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="impaired">impaired</option>
                  <option value="not impaired">not impaired</option>
                </select>
              </td>
              <td>
                <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
              </td>
            </tr>
            <tr>
              <td style="width: 200px;">Stand<input type="text" name="issue[]" value="Sit" style="display: none;"><input type="text" name="tp[]" value="Balance dynamic" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="impaired">impaired</option>
                  <option value="not impaired">not impaired</option>
                </select>
              </td>
              <td>
                <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
              </td>
            </tr>
            <tr>
              <td style="width: 200px;">Endurance/activity tolerance<input type="text" name="issue[]" value="Endurance/activity tolerance" style="display: none;"></td>
              <td>
                <select name="answer[]" class="form-control">
                  <option value="Reduced">Reduced</option>
                  <option value="normal">normal</option>
                </select>
              </td>
              <td>
                <textarea name="Comment[]" required="" class="form-control" placeholder="Enter comment here"></textarea>
              </td>
            </tr>
          </table>

          <input type="submit" name="" value="Continue" class="btn btn-primary">

        </form>

      </div>
    </div>


  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Library/WebServer/Documents/physio/resources/views/occp/occSixth.blade.php ENDPATH**/ ?>                                                                                                                                                                                                   