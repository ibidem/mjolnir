#!/usr/bin/env ruby

require 'rubygems'
require 'nyx'

basedir = File.expand_path(File.dirname(__FILE__))
Dir.chdir basedir
Nyx.new.compile_style
