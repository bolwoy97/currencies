<?
if(!$currencies){
    echo 'Service is unreachable now, try later!';
}else{
    foreach($currencies as $cur):?>
    <tr>
        <th><?=$cur['valuteID']?></th>
        <td><?=$cur['numCode']?></td>
        <td><?=$cur['сharCode']?></td>
        <td><?=$cur['name']?></td>
        <td><?=$cur['value']?></td>
        <td><?=date('Y-m-d',$cur['date'])?></td>
    </tr>
    <?endforeach;
}?>