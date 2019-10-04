    <!-- gamecenter mod modal -->
    <!-- 目前弃用
    嵌入页面的添加游戏厅的弹出框 -->
    <div class="modal fade" id="gamecenterAdd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">添加游戏厅</h4>
          </div>
          <div class="modal-body">
            <form id='form1' action="/php/gcHandle.php" method="post">
              <div class="form-group">
                <input name="city" type="text" class="form-control inline-input-200" id="city" placeholder="城市名">
                <label for="city">市</label>
                <input name="area" type="text" class="form-control inline-input-200" id="area" placeholder="区名">
                <label for="area">区</label>
              </div>
              <div class="form-group">
                <label for="place">地点</label>
                <input name="place" type="text" class="form-control" id="place" placeholder="XXX商场">
              </div>
              <div class="form-group">
                <label for="name">名称</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="XXX游乐园">
              </div>
              <div class="form-group">
                <label for="lng">经度</label>
                <input name="lng" type="text" class="form-control inline-input-200" id="lng" placeholder="12.345678">
                <label for="lat">纬度</label>
                <input name="lat" type="text" class="form-control inline-input-200" id="lat" placeholder="12.345678">
                <p>目前高德地图组件有些问题，造成的不便十分抱歉。。。暂时的解决办法：</p>
                <p><a target="_blank" href="https://lbs.amap.com/api/javascript-api/example/geocoder/regeocoding">前往这里</a>选择地点后复制经纬度坐标，经度在前纬度在后复制进来，注意去掉中间的逗号</p>
              </div>
              <div class="form-group">
                <label for="info">备注</label>
                <input name="info" type="text" class="form-control" id="info" placeholder="一些其他信息">
              </div>
              <button type="submit" class="btn btn-primary">提交</button>
            </form>
          </div>
        </div>
      </div>
    </div>