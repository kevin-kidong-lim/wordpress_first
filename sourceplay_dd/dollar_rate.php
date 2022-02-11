<?php

?>
<div class="wrap">
<h1>달러 환율 수집 리스트</h1>
<div class="table_warp">
    <table class="table_class">
        <tr>
            <th>번호</th>
            <th>달러->원환율</th>
            <th>등록일</th>
        </tr>
        <tbody class="the-list">
        <?php
          $idx = 0;
          foreach($rate_list as $this_rate)
          {
              $idx++;
              ?>
        <tr>
            <td><?php echo $idx;?></td>
            <td><?php echo $this_rate->won_for_1_dollar;?></td>
            <td><?php echo $this_rate->insert_date;?></td>
        </tr>
        <?php
          }

          if($rate_list == null || !$rate_list){
              ?>
            <tr>
                <td colspan=3>no data</td>
            </tr>
              <?php
          }
          ?>
        </tbody>
        
    </table>
    <div class="divShortCode">
        <div>
            <textarea name="" id="" cols="30" rows="10">
                [sourceplay-dollar money="숫자로 된 수치"]
            </textarea>
        </div>
    </div>
</div>
</div>