<div class="di"
    style="height:540px; border:#999 1px solid; width:76.5%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
    <!--正中央-->
    <?php include_once "logout.php";?>
    <div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
        <p class="t cent botli">最新消息資料內容管理</p>
        <form method="post" action="./api/edit.php">
            <table width="100%">
                <tbody>
                    <tr class="yel">
                        <td width="80%">最新消息資料內容</td>
                        <td width="10%">顯示</td>
                        <td width="10%">刪除</td>
                    </tr>

                    <!-- 設置了每頁顯示的數量，即每頁顯示 4 條數據 -->
                    <!-- 通過 $News->count() 來獲取所有符合條件的新聞記錄數量，並將其存儲在 $total 變數中。這樣可以計算出總共有多少條新聞 -->
                    <!-- 計算總共需要多少頁來顯示所有的新聞。ceil 函數是向上取整的意思，這樣即使最後一頁的新聞數量少於 $div 條，也會多出一頁 -->
                    <!-- 獲取當前頁數。$_GET['p'] 是從 URL 中獲取參數 p 的值，?? 是 PHP 的空合併運算符，表示如果 $_GET['p'] 沒有被設置，則默認設置當前頁數為 1-->
                    <!-- 計算了從哪條記錄開始查詢。$now-1 是當前頁數減 1，然後乘以每頁顯示的條數 $div，得出起始的數據位置（即 SQL 查詢中的 LIMIT 起始位置）。例如，如果當前頁是第 2 -->
                    <!-- 頁，那麼開始查詢的數據是從第 5 條（即第 4 條後）開始 -->

                    <!-- 從資料庫中查詢新聞。$News->all() 會執行一個 SQL 查詢來獲取數據，這裡使用了 LIMIT 子句來控制每次查詢返回的記錄範圍，這樣每次只會獲取當前頁所需顯示的數據。$start -->
                    <!-- 是查詢的起始位置，$div 是每頁顯示的條數 -->



                    <?php

                    $div=4;
                    $total=$News->count();
                    $pages=ceil($total/$div);
                    $now=$_GET['p']??1;
                    $start=($now-1)*$div;

                    $rows=$News->all(" limit $start,$div");
                    foreach($rows as $row){
                    ?>
                    <tr>
                        <td>
                            <textarea name="text[]" style="width:95%;height:60px;"><?=$row['text'];?></textarea>
                        </td>
                        <td>
                            <input type="checkbox" name="sh[]" value="<?=$row['id'];?>"
                                <?=($row['sh']==1)?'checked':'';?>>
                        </td>
                        <td>
                            <input type="checkbox" name="del[]" value="<?=$row['id'];?>">
                        </td>
                        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="cent">
                <?php

                if(($now-1)>0){
                    $prev=$now-1;
                    echo "<a href='?do=$do&p=$prev'> < </a>";
                }
                for($i=1;$i<=$pages;$i++){
                    $size=($i==$now)?"24px":"16px";
                    echo "<a href='?do=$do&p=$i' style='font-size:$size'> ";
                    echo $i;
                    echo " </a>";
                }
                if(($now+1)<=$pages){
                    $next=$now+1;
                    echo "<a href='?do=$do&p=$next'> > </a>";
                }

            ?>
            </div>
            <table style="margin-top:40px; width:70%;">
                <tbody>
                    <tr>
                        <td width="200px">
                            <input type="button"
                                onclick="op(&#39;#cover&#39;,&#39;#cvr&#39;,&#39;./modal/<?=$do;?>.php?table=<?=$do;?>&#39;)"
                                value="新增最新消息資料">
                        </td>
                        <td class="cent">
                            <input type="hidden" name="table" value="<?=$do;?>">
                            <input type="submit" value="修改確定">
                            <input type="reset" value="重置">
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
</div>