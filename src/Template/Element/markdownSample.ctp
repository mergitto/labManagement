<?php
  echo $this->Form->textarea('markdown', ['type' => 'text', 'class' => "comment-area form-control login-form posts",
    'value' => '# 見出し 1
## 見出し 2
### 見出し 3
[リンク](http://...)
```
コード
```
- リスト 1
- リスト 2
    - リスト 2-1

1. 番号付きリスト 1
2. 番号付きリスト 2
3. 番号付きリスト 3
'])
?>
