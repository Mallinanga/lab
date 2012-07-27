require 'toto'
# require 'coderay'
# require 'rack/codehighlighter'

use Rack::Static, :urls => ['/css', '/js', '/images', '/favicon.ico'], :root => 'public'
# use Rack::ShowExceptions
# use Rack::CommonLogger
# use Rack::Codehighlighter, :coderay, :markdown => true, :element => "pre>code", :pattern => /\A:::(\w+)\s*(\n|&#x000A;)/i, :logging => false

# if ENV['RACK_ENV'] == 'development'
#   use Rack::ShowExceptions
# end

toto = Toto::Server.new do
  # set :author,    ENV['USER']
  set :author,      'Panos G. Pgn'
  # set :tags,      'no-tag'
  # set :title,     Dir.pwd.split('/').last
  # set :url,       'http://example.com'
  # set :prefix,    ''                                        # common path prefix for all pages
  # set :root,      "index"
  set :date,        lambda {|now| now.strftime("%d/%m/%Y") }
  # set :date,      lambda {|now| now.strftime("%B #{now.day.ordinal} %Y") }
  # set :markdown,  :smart
  set :disqus,      false
  # set :summary,   :max => 100, :delim => /~/
  set :summary,     :max => 100, :delim => /~\n/
  set :ext,         'txt'
  set :cache,       28800
  set :error        do |code|
    "<center><font style='font-size:300%;font-weight:bold'>#{code}</font></center>"
  end
  # set :error      go "/error/#{code}.html"
  # set :error      File.read("public/#{code}.html")
  # set :to_html    do |path, page, ctx|
  # ERB.new(File.read("#{path}/#{page}.rhtml")).result(ctx)
  # end
end

run toto
