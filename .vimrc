set nocompatible              " be iMproved, required
filetype off                  " required

set ai                  " auto indenting
set history=100         " keep 100 lines of history
set tabstop=4
set shiftwidth=4
set showmatch
set colorcolumn=100
set hlsearch
set encoding=utf8
set fileencoding=utf8

syntax on

highlight ExtraWhitespace ctermbg=red guibg=red
match ExtraWhitespace /^\t*\zs \+/
match ExtraWhitespace /\s\+$/

autocmd BufWritePre * :%s/\s\+$//e
autocmd BufWritePre * :%s/\r\+$//e

set completeopt=longest,menuone

execute pathogen#infect()

" set the runtime path to include Vundle and initialize
set rtp+=~/.vim/bundle/Vundle.vim
call vundle#begin()

" let Vundle manage Vundle, required
Plugin 'VundleVim/Vundle.vim'

" general
Plugin 'navicore/vissort.vim'

" php
Plugin 'https://github.com/StanAngeloff/php.vim.git'

Plugin 'ervandew/supertab'
Plugin 'Shougo/vimproc.vim'
Plugin 'Shougo/unite.vim'
Plugin 'joonty/vdebug.git'

Bundle 'joonty/vim-phpqa.git'

let g:phpqa_codesniffer_args = " --standard=/var/www/wiki/w/vendor/mediawiki/mediawiki-codesniffer/MediaWiki/ruleset.xml"
let g:phpqa_messdetector_ruleset = "/var/www/wiki/w/extensions/Wikidata/vendor/wikibase/data-model/phpmd.xml""

" javascript

Plugin 'pangloss/vim-javascript'
Plugin 'jelera/vim-javascript-syntax'

" au FileType javascript call JavaScriptFold()

autocmd BufRead *.php :UnusedImports
