FROM node:16.17.1-alpine3.15

# make the 'app' folder the current working directory
WORKDIR /app

# copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./
# install project dependencies
RUN rm -rf node_modules
RUN yarn install

# copy project files and folders to the current working directory (i.e. 'app' folder)
COPY . .

#
# build app for production with minification
CMD [ "yarn", "devdocker" ]