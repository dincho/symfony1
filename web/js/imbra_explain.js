function imbra_explain (question_id, answer)
{
  ls = document.getElementById('label_explains_' + question_id ).style;
  ts = document.getElementById('explains_' + question_id ).style;
  
  if( answer == 1 )
  {
    ls.display = '';
    ts.display = '';
  } else {
    ls.display = 'none';
    ts.display = 'none';
  }
}