FROM node:16 AS build

WORKDIR /home/node/
COPY . .
RUN yarn install
RUN yarn run generate

FROM nginx:alpine AS deploy

COPY nginx-config/ /etc/nginx/

COPY --from=build /home/node/dist /usr/share/nginx/html
