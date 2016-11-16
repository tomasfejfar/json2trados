# JSON2Trados

This tool helps you to convert JSON (key : translation) file(s) to CSVs to use in Trados/MemoQ/etc. It also allows you to convert translated files back. 

## Usage

```
$ php convert.php trados:to original_en.js output.csv [-p pretranslated_cs.js]
$ php convert.php trados:from translated.csv translated_cs.json [-c 2]
````
`[]` marks optional parameter

`php convert.php` outputs further information or use `php convert.php help trados:from`. 

Please feel free to add issues/PRs here on github.  
