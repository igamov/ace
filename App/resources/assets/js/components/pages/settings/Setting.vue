<template>
  <div>
    <h1 class="mb-4">Настройки системы</h1>
    <div class="item-wrapper">
      <div class="tab-container ">
        <ul class="nav nav-tabs" id="bt-tab_1" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="bt-tab_1_1" data-toggle="tab" href="#bt-content_1_1" role="tab"
               aria-controls="bt-content_1_1" aria-selected="true">Общие</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_2" data-toggle="tab" href="#bt-content_1_2" role="tab"
               aria-controls="bt-content_1_2" aria-selected="false">Компании</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_3" data-toggle="tab" href="#bt-content_1_3" role="tab"
               aria-controls="bt-content_1_3" aria-selected="false">Задачи</a>
          </li>
        </ul>
        <div class="tab-content" id="bt-tab_content_1" style="padding: 30px 0 0 0; background: none;">
          <div class="tab-pane show active" id="bt-content_1_1" role="tabpanel" aria-labelledby="bt-tab_1_1">
            <div class="row">
              <companyDetail/>
              <Nds/>
            </div>
          </div>
          <div class="tab-pane" id="bt-content_1_2" role="tabpanel" aria-labelledby="bt-tab_1_2">
            <div class="row">
              <Priority/>
              <AreaActivity/>
            </div>
          </div>
          <div class="tab-pane" id="bt-content_1_3" role="tabpanel" aria-labelledby="bt-tab_1_3">
            <div class="row">
              <Status/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Priority from './prioritySetting';
  import AreaActivity from './areaActivitySetting';
  import Nds from './ndsSetting';
  import companyDetail from './companySetting';
  import Status from './statusSetting';
  export default {
    components: {
      companyDetail,
      Priority,
      AreaActivity,
      Nds,
      Status,
    }
  }
</script>
