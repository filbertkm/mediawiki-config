set nocompatible
set colorcolumn=100
set background=dark
set showmatch
set ruler
set hls
set tabstop=4

highlight ExtraWhitespace ctermbg=red guibg=red
match ExtraWhitespace /^\t*\zs \+/
match ExtraWhitespace /\s\+$/

autocmd BufWritePre * :%s/\s\+$//e
