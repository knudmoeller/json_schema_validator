        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <p>
          Developed and hosted by <a href="http:/datalysator.com">Datalysator</a> (<a href="http://datalysator.com/contact/">Contact</a>) 
        </p>
        <p>
          Validation performed using Geraint Luff's <a href="https://github.com/geraintluff/jsv4-php">jsv4-php</a>
        </p>
        <p>
          Designed using <a href="http://getbootstrap.com/">Bootstrap</a> 
        </p>
        <div class="legal">
          <small>
            THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
          </small>
        </div>
      </div>
    </footer>
  </div>

	</div>
  <script src="//code.jquery.com/jquery.js"></script>
  <!--<script src="/wp-includes/js/jquery/jquery.js"></script>-->
  <script src="js/bootstrap.min.js"></script>
  <script>
    $('a[data-toggle="tab"]').on('shown', function (e) {
      tab = $(e.target).attr('href');
      tab = tab.substr(1);
      elem = 'input[value="' + tab + '"]';
      $(elem).prop("checked", true);
    })
  </script>
  </body>
</html>
