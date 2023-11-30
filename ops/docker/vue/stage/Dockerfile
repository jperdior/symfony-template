FROM node:18.17.1-alpine3.18

LABEL org.opencontainers.image.source=https://github.com/jperdior/landingpagegenerator
# install simple http server for serving static content
RUN npm install -g http-server

# make the 'app' folder the current working directory
WORKDIR /app

# copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./
RUN echo $(ls -1 /app)
# install project dependencies
RUN rm -rf node_modules
RUN yarn install

# copy project files and folders to the current working directory (i.e. 'app' folder)
COPY . .

#
# build app for production with minification
#RUN yarn build --mode=stage

CMD [ "http-server", "dist"]